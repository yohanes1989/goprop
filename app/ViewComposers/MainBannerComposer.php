<?php

namespace GoProp\ViewComposers;

use GoProp\Models\MainBanner;
use Illuminate\Contracts\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MainBannerComposer
{
    protected $app;
    protected $request;

    public function __construct()
    {
        $this->app = app();

        $this->request = $this->app['request'];
    }

    public function compose(View $view)
    {
        $path = $this->request->path();
        $currentLanguage = LaravelLocalization::getCurrentLocale();

        if(starts_with($path, $currentLanguage.'/')){
            $path = str_replace($currentLanguage.'/', '', $path);
        }elseif($path == $currentLanguage){
            $path = str_replace($currentLanguage, '', $path);
        }

        $main_banners = MainBanner::inURL($path)->get();

        $view->with([
            'main_banners' => $main_banners
        ]);
    }
}