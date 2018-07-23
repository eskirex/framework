<?php

    namespace Eskirex\Component\Framework;

    class Error
    {
        public static function http(int $code)
        {
            $view = new View();

            $view->name("Errors/{$code}.twig")
                ->render();
        }
    }