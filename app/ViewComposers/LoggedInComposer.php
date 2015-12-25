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
        $urlSegments = explode('/', $route->getUri());
        $prefix = $urlSegments[0];

        $view->with('active_section', $prefix);
    }
}