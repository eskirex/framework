<?php

    namespace Eskirex\Component\Framework;

    use Eskirex\Component\Config\Config;
    use Eskirex\Component\Framework\Configurations\FrameworkConfiguration;
    use Eskirex\Component\Framework\Exceptions\KernelNotFoundException;
    use Eskirex\Component\Framework\Exceptions\RuntimeException;
    use Eskirex\Component\Framework\Exceptions\InvalidArgumentException;

    class Framework
    {
        /**
         * Framework constructor.
         * @param array $kernel
         * @throws InvalidArgumentException
         * @throws KernelNotFoundException
         * @throws RuntimeException
         */
        public function __construct(array $kernel)
        {
            if (!FrameworkConfiguration::$baseDir) {
                throw new RuntimeException('Base dir not setted');
            }

            $kernelConfig = new Config('Kernel');
            $kernels = $kernelConfig->get($kernel);

            if(!$kernels){
                throw new KernelNotFoundException('Kernel not found');
            }

            foreach ($kernels as $class) {
                if (!class_exists($class)) {
                    throw new InvalidArgumentException("Invalid kernel class {$class}");
                }

                new $class();
            }
        }


        public static function configure(array $data)
        {
            new FrameworkConfiguration($data);
        }
    }