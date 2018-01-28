<?php

    namespace Eskirex\Component\Framework\Services;

    use Eskirex\Component\Framework\Routing;

    class RouteService
    {
        public function __construct()
        {
            new Routing();
        }
    }