<?php

namespace Webpresso\MyShortCart\Facades;

use Illuminate\Support\Facades\Facade;

class MyShortCart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'myshortcart';
    }
}