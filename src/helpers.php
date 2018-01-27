<?php

if (!function_exists('vdump')) {
    function vdump($input)
    {
        echo "<pre style='font-size:16px;'>";
        var_dump($input);
        echo '</pre>';
    }
}

if (!function_exists('pdump')) {
    function pdump($input)
    {
        echo '<pre>';
        print_r($input);
        echo '</pre>';
    }
}

if (!function_exists('is_cli')) {
    function is_cli()
    {
        if (defined('STDIN')) {
            return true;
        }

        if (php_sapi_name() === 'cli') {
            return true;
        }

        if (PHP_SAPI === 'cli') {
            return true;
        }

        if (stristr(PHP_SAPI, 'cgi') && getenv('TERM')) {
            return true;
        }
    }
}

