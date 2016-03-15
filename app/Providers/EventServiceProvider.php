<?php

namespace GoProp\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'GoProp\Events\PaymentCompletedEvent' => [
            'GoProp\Listeners\PaymentEventListener',
        ],
        'GoProp\Events\PaymentFailedEvent' => [
            'GoProp\Listeners\PaymentEventListener',
        ],
        'GoProp\Events\PaymentCancelledEvent' => [
            'GoProp\Listeners\PaymentEventListener',
        ],
    ];

    protected $subscribe = [
        'GoProp\Listeners\NotificationEventListener'
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
