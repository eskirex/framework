<?php

namespace Eskirex\Component\Framework\Traits;

trait ModelTrait
{
    use ModelCommonTrait;


    private function doInsert()
    {

    }


    private function doUpdate()
    {
        echo 'doUpdate';
    }


    private function doDelete()
    {
        echo 'doDelete';
    }
}