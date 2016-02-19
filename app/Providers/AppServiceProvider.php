<?php

namespace GoProp\Providers;

use GoProp\Validator\CustomValidator;
use Illuminate\Support\ServiceProvider;
use GoProp\Facades\PropertyCompareHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->resolver(function($translator, $data, $rules, $messages)
        {
            return new CustomValidator($translator, $data, $rules, $messages);
        });

        $this->app->singleton('project_helper', 'GoProp\Helpers\ProjectHelper');
        $this->app->singleton('agent_helper', 'GoProp\Helpers\AgentHelper');
        $this->app->singleton('address_helper', 'GoProp\Helpers\AddressHelper');
        $this->app->singleton('property_compare_helper', 'GoProp\Helpers\PropertyCompareHelper');

        view()->composer('frontend.account.logged_in.layout', 'GoProp\ViewComposers\LoggedInComposer');

        view()->composer('frontend.property.compare_bar', 'GoProp\ViewComposers\PropertyComposer');

        view()->composer('frontend.master.layout_with_slider', 'GoProp\ViewComposers\MainBannerComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
