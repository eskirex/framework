<?php

    namespace Eskirex\Component\Framework;

    use Eskirex\Component\Framework\Configurations\FrameworkConfiguration;
    use Eskirex\Component\Framework\Exceptions\InvalidArgumentException;

    class Framework
    {
        public function __construct(array $kernel)
        {
            foreach ($kernel as $class) {
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