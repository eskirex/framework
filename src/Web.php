<?php

namespace Eskirex\Component\Web;

use Eskirex\Component\Config\Config;
use Eskirex\Component\Session\Session;
use Eskirex\Component\Web\Traits\WebTrait;

class Web
{
    use WebTrait;


    public function __construct()
    {
        Config::configure([
            'dir' => self::config('config.dir')
        ]);

        if (is_cli()) {
            $this->initCLI();
        } else {
            $this->initHTTP();
        }
    }


    public function initHTTP()
    {
        (new Session())->start();
        (new Routing());
    }


    public function initCLI()
    {
        (new CLI());
    }


    /**
     * @param array|string $set
     * @return mixed
     */
    public static function configure($set)
    {
        return self::doConfigure($set);
    }


    public static function config($get)
    {
        return self::getConfig($get);
    }
}