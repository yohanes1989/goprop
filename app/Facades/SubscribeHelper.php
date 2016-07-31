<?php

namespace GoProp\Facades;

use Illuminate\Support\Facades\Facade;

class SubscribeHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'subscribe_helper';
    }
}