<?php

    namespace Eskirex\Component\Framework\Configurations;

    use Eskirex\Component\Dotify\Dotify;

    class TwigConfiguration
    {
        public static function functions()
        {
            return [
                'vdump'      => function ($input) {
                    echo '<pre>';
                    var_dump($input);
                    echo '</pre>';
                },
                'pdump'      => function ($input) {
                    echo '<pre>';
                    print_r($input);
                    echo '</pre>';
                },
                'strtolower' => function ($input) {
                    return strtolower($input);
                },
                'dot'        => function ($input) {
                    return new Dotify($input);
                },
                'class'      => function ($input) {
                    $input = str_replace('/', '\\', $input);

                    return new $input;

                },
                'config'     => function ($type) {
                    $class = 'Eskirex\Component\Config\Config';

                    return new $class($type);
                },
                'define'     => function ($name) {
                    $defines = new Dotify(get_defined_constants());

                    return $defines->get($name);
                }
            ];
        }


        public static function filters()
        {
            return [
                'vdump' => function ($input) {
                    echo '<pre>';
                    var_dump($input);
                    echo '</pre>';
                },
                'pdump' => function ($input) {
                    echo '<pre>';
                    print_r($input);
                    echo '</pre>';
                },

                'strtolower' => function ($input) {
                    return strtolower($input);
                },
                'dot'        => function ($input) {
                    return new Dotify($input);
                },
                'class'      => function ($input) {
                    $input = str_replace('/', '\\', $input);

                    return new $input;
                },
                'config'     => function ($type) {
                    $class = 'Eskirex\Component\Config\Config';

                    return new $class($type);
                }
            ];
        }
    }