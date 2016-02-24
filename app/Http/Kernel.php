<?php

namespace GoProp\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \GoProp\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \GoProp\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \GoProp\Http\Middleware\Authenticate::class,
        'admin.auth' => \GoProp\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \GoProp\Http\Middleware\RedirectIfAuthenticated::class,
        'acl' => \Kodeine\Acl\Middleware\HasPermission::class,
        'menu' => \GoProp\Http\Middleware\MenuMiddleware::class,
        'property_owner' => \GoProp\Http\Middleware\PropertyOwner::class,
        'property_cart_order' => \GoProp\Http\Middleware\PropertyCartOrder::class,
        'property_editable' => \GoProp\Http\Middleware\PropertyEditable::class,
        'likeable' => \GoProp\Http\Middleware\Likeable::class,
        'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'admin.can_edit' => \GoProp\Http\Middleware\Admin\CanEdit::class,
    ];
}
