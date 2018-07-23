<?php

    namespace Eskirex\Component\Framework;

    use Eskirex\Component\Config\Config;
    use Eskirex\Component\Framework\Configurations\FrameworkConfiguration;
    use Eskirex\Component\Framework\Configurations\TwigConfiguration;
    use Eskirex\Component\Framework\Framework;
    use Twig_Environment;
    use Twig_Filter;
    use Twig_Function;
    use Twig_Loader_Filesystem;
    use WyriHaximus\HtmlCompress\Compressor\HtmlCompressor;

    class View
    {
        protected $config;

        protected $handler;

        protected $name;

        protected $data;


        public function __construct()
        {
            $this->config = new Config('Template');

            $loader = new Twig_Loader_Filesystem(FrameworkConfiguration::$templateDir);

            $options = [
                'debug'               => false,
                'charset'             => 'UTF-8',
                'base_template_class' => 'Twig_Template',
                'strict_variables'    => false,
                'autoescape'          => 'html',
                'cache'               => FrameworkConfiguration::$tempDir . 'twig',
                'auto_reload'         => true,
                'optimizations'       => -1,
            ];

            $functions = TwigConfiguration::functions();

            $filters = TwigConfiguration::filters();

            if ($configTwigOptions = $this->config->get('twig.options')) {
                foreach ($configTwigOptions as $key => $value) {
                    $options[$key] = $value;
                }
            }

            if ($configTwigFunctions = $this->config->get('twig.functions')) {
                foreach ($configTwigFunctions as $key => $value) {
                    $functions[$key] = $value;
                }
            }

            if ($configTwigFilters = $this->config->get('twig.functions')) {
                foreach ($configTwigFilters as $key => $value) {
                    $filters[$key] = $value;
                }
            }

            $this->handler = new Twig_Environment($loader, $options);

            foreach ($functions as $key => $item) {
                $this->handler->addFunction(new Twig_Function($key, $item));
            }

            foreach ($filters as $key => $item) {
                $this->handler->addFilter(new Twig_Filter($key, $item));
            }
        }


        public function name($name)
        {
            $this->name = $name;

            return $this;
        }


        public function data($data)
        {
            if ($configData = $this->config->get('data')) {
                foreach ($configData as $key => $value) {
                    $data[$key] = $value;
                }
            }

            $this->data = $data;

            return $this;
        }


        public function render(bool $return = false)
        {
            $data = $this->handler->render($this->name, $this->data ?? []);

            if ($this->config->get('output_compress')) {
                $compressor = new HtmlCompressor();
                $data = $compressor->compress($data);
            }
            if ($return) {
                return $data;
            }

            echo $data;
        }
    }