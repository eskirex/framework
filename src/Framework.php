<?php

    namespace Eskirex\Component\Framework;

    use Eskirex\Component\Config\Config;
    use Eskirex\Component\Console\Console;
    use Eskirex\Component\Console\Output;
    use Eskirex\Component\Console\Input;
    use Eskirex\Component\Framework\Commands\Asset\MakeAsset;
    use Eskirex\Component\Framework\Commands\Storage\LinkStorage;
    use Eskirex\Component\Framework\Configurations\FrameworkConfiguration;
    use Eskirex\Component\Framework\Exceptions\RuntimeException;
    use Eskirex\Component\Framework\Exceptions\InvalidArgumentException;

    class Framework
    {
        /**
         * Framework constructor.
         * @param string $kernel
         * @throws InvalidArgumentException
         * @throws RuntimeException
         */
        public function __construct(string $kernel)
        {

            if (!FrameworkConfiguration::$baseDir) {
                throw new RuntimeException('Base dir not setted');
            }

            $kernelConfig = new Config('Kernel');
            $applicationConfig = new Config('Application');

            if (($kernels = $kernelConfig->get($kernel)) === null) {
                throw new InvalidArgumentException('Invalid kernel');
            }

            if ($this->isConsole() === false) {
                if (!empty($kernels)) {
                    foreach ($kernels as $class) {
                        if (!class_exists($class)) {
                            throw new InvalidArgumentException("Invalid kernel class {$class}");
                        }

                        new $class();
                    }
                }
            } else {

                // Including CLI
                $console = new Console(
                    $applicationConfig->get('console_name'),
                    $applicationConfig->get('console_version'),
                    $applicationConfig->get('language')
                );

                // Load default commands
                $console
                    ->addCommand(new MakeAsset())
                    ->addCommand(new LinkStorage());

                if (!empty($kernels)) {
                    foreach ($kernels as $class) {
                        if (!class_exists($class)) {
                            throw new InvalidArgumentException("Invalid kernel class {$class}");
                        }

                        $console->addCommand(new $class());
                    }
                }

                // Start CLI
                $console->run(new Input(), new Output());
            }
        }


        public static function configure(array $data)
        {
            new FrameworkConfiguration($data);
        }


        public function isConsole()
        {
            if (defined('STDIN')) {
                return true;
            }

            if (in_array(PHP_SAPI, array('cli', 'cli-server', 'phpdbg'))) {
                return true;
            }

            if (isset($_SERVER['argc']) && (is_numeric($_SERVER['argc']) && $_SERVER['argc'] > 0)) {
                return true;
            }

            if (array_key_exists('SHELL', $_SERVER)) {
                return true;
            }

            if (empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) {
                return true;
            }

            if (!array_key_exists('REQUEST_METHOD', $_SERVER)) {
                return true;
            }

            return false;
        }
    }