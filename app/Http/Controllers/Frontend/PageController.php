<?php

namespace GoProp\Http\Controllers\Frontend;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\PackageCategory;

class PageController extends Controller
{
    public function home()
    {
        $packageCategories = PackageCategory::all();

        return view('frontend.page.home', [
            'packageCategories' => $packageCategories
        ]);
    }

    public function propertyTermsConditions()
    {
        return view('frontend.page.property_terms_conditions');
    }
}