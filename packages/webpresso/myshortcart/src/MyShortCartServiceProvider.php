<?php

namespace Webpresso\MyShortCart;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class MyShortCartServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function register()
    {
        $this->app->singleton('myshortcart', function($app){
            return new MyShortCart($app['db']->connection());
        });

        $this->mergeConfigFrom(
            __DIR__.'/../config/myshortcart.php', 'myshortcart'
        );
    }

    public function boot()
    {
        $this->_setupRoutes($this->app->router);

        $this->publishes([
            __DIR__.'/../config/myshortcart.php' => config_path('myshortcart.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->loadViewsFrom(__DIR__.'/Views', 'myshortcart');

        /*
        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/vendor/myshortcart'),
        ], 'views');
        */
    }

    protected function _setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Webpresso\MyShortCart\Http\Controllers'], function($router){
            $router->controller('myshortcart', 'PaymentController');
        });
    }
}