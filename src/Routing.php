<?php

    namespace Eskirex\Component\Framework;

    use Eskirex\Component\Config\Config;
    use Eskirex\Component\Framework\Configurations\FrameworkConfiguration;
    use Eskirex\Component\HTTP\Response;
    use Eskirex\Component\HTTP\Request;

    class Routing
    {
        protected $request;

        protected $response;

        protected $routes;


        public function __construct()
        {
            $routeConfig = new Config('Route');
            $this->routes = $routeConfig->all();

            $this->request = new Request();
            $this->response = new Response();

            $this->response->send($this->doRun($this->getCallback()));
        }


        protected function getCallback()
        {
            return array_key_exists($this->getRoute(), $this->routes) ? $this->routes[$this->getRoute()] : null;
        }


        protected function getRoute()
        {
            return array_key_exists($this->request->segment(0), $this->routes) ? $this->request->segment(0) : '/';
        }


        protected function doRun($callback)
        {
            if (is_callable($callback)) {
                return $callback($this->request, $this->response);
            }

            if (is_string($callback)) {
                $class = FrameworkConfiguration::$controllersNamespace . $callback;
                $action = $this->isAction($callback);

                if (class_exists($class)) {
                    $controller = $action ? new $action : new $class;
                    $method = $this->getRoute() === '/' ? $this->request->segment(0) : $this->request->segment(1);

                    if (method_exists($controller, $method)) {
                        return $controller->{$method}($this->request, $this->response);
                    }

                    return $controller->{FrameworkConfiguration::CONTROLLER_DEFAULT_METHOD}();
                }

                return $callback;
            }
        }


        protected function isAction($callback)
        {
            $requestMethod = ucfirst(strtolower($this->request->method()));
            $parseHandler = explode('\\', $callback);
            $isXhr = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? true : false;

            $action = FrameworkConfiguration::$controllersNamespace . '\\' . $parseHandler[0] . '\Action' . ($isXhr ? '\XHR' : '') . '\\' . $requestMethod . 'Action';

            if (class_exists($action)) {
                return $action;
            }

            return false;
        }
    }