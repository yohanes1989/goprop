<?php

namespace GoProp\Facades;

use Illuminate\Support\Facades\Facade;

class AgentHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'agent_helper';
    }
}