<?php

    namespace Eskirex\Component\Framework\Services;

    use Eskirex\Component\Session\Session;

    class SessionService
    {
        /**
         * SessionService constructor.
         * @throws \Eskirex\Component\Session\Exceptions\SessionRuntimeException
         */
        public function __construct()
        {
            $session = new Session();
            $session->start();
        }
    }