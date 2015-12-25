<?php

namespace GoProp\Facades;

use Illuminate\Support\Facades\Facade;

class PropertyCompareHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'property_compare_helper';
    }
}