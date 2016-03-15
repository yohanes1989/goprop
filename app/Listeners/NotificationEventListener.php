<?php

namespace GoProp\Listeners;

use GoProp\Facades\ProjectHelper;
use Kodeine\Acl\Models\Eloquent\Role;

class NotificationEventListener
{
    /*
     * @param GoProp\Events\PropertyEvent
     */
    public function onNewProperty($event)
    {
        $property = $event->property;

        if($event->type == 'new'){
            //Send order confirmation to admin
            $administratorRole = Role::where('slug', 'administrator')->first();
            $users = $administratorRole->users;

            ProjectHelper::sendMail(
                $users->lists('email')->all(),
                'New Property: '.$property->property_name,
                'admin.emails.property.new',
                [
                    'property' => $property,
                ]
            );
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'GoProp\Events\PropertyEvent',
            'GoProp\Listeners\NotificationEventListener@onNewProperty'
        );
    }
}
