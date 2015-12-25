<?php

namespace GoProp\Facades;

use Illuminate\Support\Facades\Facade;

class ProjectHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'project_helper';
    }
}