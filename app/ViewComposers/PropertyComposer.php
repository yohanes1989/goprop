<?php

namespace GoProp\ViewComposers;

use Illuminate\Contracts\View\View;
use GoProp\Facades\PropertyCompareHelper;

class PropertyComposer
{
    public function __construct()
    {

    }

    public function compose(View $view)
    {
        if($view->getName() == 'frontend.property.compare_bar'){
            $propertiesInComparison = PropertyCompareHelper::getCurrentList();
            $view->with('propertiesInComparison', $propertiesInComparison);
        }
    }
}