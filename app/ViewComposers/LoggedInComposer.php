<?php

namespace GoProp\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;

class LoggedInComposer
{
    public function __construct()
    {

    }

    public function compose(View $view)
    {
        $route = Request::route();

        $view->with('active_section', $route->getUri());
    }
}