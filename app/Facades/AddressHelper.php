<?php

namespace GoProp\Facades;

use Illuminate\Support\Facades\Facade;

class AddressHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'address_helper';
    }
}