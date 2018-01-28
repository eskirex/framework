<?php

namespace Eskirex\Component\Framework;

use Eskirex\Component\HTTP\Request;
use Eskirex\Component\HTTP\Response;

class Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response,
     */
    protected $response;

    /**
     * @var View
     */
    protected $view;


    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->view = new View();
    }
}