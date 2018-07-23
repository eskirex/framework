<?php

    namespace Eskirex\Component\Framework;

    use Eskirex\Component\Dotify\Dotify;
    use Eskirex\Component\Framework\Configurations\FrameworkConfiguration;
    use Eskirex\Component\Config\Config;
    use Eskirex\Component\HTTP\Resources\Status;
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

            $route = $this->getRoute();
            if (!array_key_exists($route, $this->routes)) {
                Error::http(Status::HTTP_NOT_FOUND);

                return;
            }

            $route = $this->routes[$route];
            if (isset($route['group'])) {
                $route = $this->group($route);
            }

            if (!isset($route['response']) || (isset($route['response']) && empty($route['response']))) {
                Error::http(Status::HTTP_SERVICE_UNAVAILABLE);

                return;
            }

            if (is_callable($route['response'])) {
                $this->send($route['response']($this->request, $this->response));

                return;
            }

            if (is_string($route['response'])) {
                $class = FrameworkConfiguration::$controllersNamespace . $route['response'];

                if (class_exists($class)) {
                    $action = $this->isAction($route['response']);
                    $controller = $action ? new $action : new $class;
                    $method = $this->request->segment(0) === '/' ? $this->request->segment(0) : $this->request->segment(1);

                    if (method_exists($controller, $method)) {
                        $controller->{$method}($this->request, $this->response);

                        return;
                    }

                    $controller->{FrameworkConfiguration::CONTROLLER_DEFAULT_METHOD}($this->request, $this->response);

                    return;
                }

                $this->send($route['response']);
            }
        }


        protected function group($route)
        {
            $segments = $this->request->segment();
            array_shift($segments);
            $groups = $route['group'];

            foreach ($segments as $key => $segment) {
                if (array_key_exists($segment, $groups)) {

                    if (!isset($segments[$key + 1])) {
                        return $groups[$segment];
                    }

                    if (isset($groups[$segment]['group'])) {
                        $groups = $groups[$segment]['group'];
                    }
                }
            }

            return $route;
        }


        protected function getRoute()
        {
            return $this->request->segment(0) ?? '/';
        }


        protected function isAction($callback)
        {

            $requestMethod = ucfirst(strtolower($this->request->method()));
            if(strtoupper($requestMethod) === "GET"){
                return false;
            }

            $controller = substr($callback, strrpos($callback, "\\") + 1);

            $namespace = str_replace($controller, '',$callback);


            $isXhr = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? true : false;

            $action = FrameworkConfiguration::$controllersNamespace . $namespace . 'Action' . ($isXhr ? '\\XHR' : '') . '\\' . $requestMethod . 'Action';

            if (class_exists($action)) {
                return $action;
            }

            return false;
        }


        protected function send($data)
        {
            $this->response->send($data);
        }
    }