<?php

namespace Eskirex\Component\Web\Traits;

use Eskirex\Component\Dotify\Dotify;

trait WebTrait
{
    /**
     * @var Dotify
     */
    public static $config;


    protected static function doConfigure($set)
    {
        if (static::$config === null) {
            static::$config = new Dotify();
        }

        if (is_array($set)) {
            static::$config->setArray($set);
        }

        if (!is_dir(static::$config->get('model.dir'))) {

        }

        if (!is_dir(static::$config->get('view.dir'))) {

        }

        if (!is_dir(static::$config->get('controller.dir'))) {

        }

        if (!is_dir(static::$config->get('config.dir'))) {

        }

        if (!is_dir(static::$config->get('var.dir'))) {

        }
    }


    protected function getConfig($get)
    {
        if (static::$config === null) {
            return null;
        }

        if (static::$config->has($get)) {
            return static::$config->get($get);
        }

        return null;
    }
}