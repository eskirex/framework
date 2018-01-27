<?php

namespace Eskirex\Component\Web;

class CLI
{
    public function __construct()
    {
        $a = array_splice($GLOBALS['argv'], 1, count($GLOBALS['argv']));
        print_r($a);
    }
}