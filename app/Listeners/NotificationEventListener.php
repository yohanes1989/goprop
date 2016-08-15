<?php

namespace GoProp\Listeners;

use GoProp\Facades\ProjectHelper;
use GoProp\Models\User;
use Kodeine\Acl\Models\Eloquent\Role;

class NotificationEventListener
{
    /*
     * @param GoProp\Events\PropertyEvent
     */
    public function propertyListener($event)
    {
        $property = $event->property;

        if($event->type == 'new'){
            //Find admin
            $administratorRole = Role::where('slug', 'administrator')->first();
            $users = $administratorRole->users;

            $sendToEmails = $users->pluck('email')->all();

            //Find property manager in that province
            $propertyManagers = User::whereHas('roles', function($query){
                $query->where('slug', 'property_manager');
            })->whereHas('profile', function($query) use ($property){
                $query->where('province', '=', $property->province);
            })->get();

            $sendToEmails = array_merge($sendToEmails, $propertyManagers->pluck('email')->all());

            ProjectHelper::sendMail(
                $sendToEmails,
                'New Property: '.$property->property_name,
                'admin.emails.property.new',
                [
                    'property' => $property,
                ]
            );
        }
    }

    /*
     * @param GoProp\Events\PropertyEvent
     */
    public function viewingScheduleListener($event)
    {
        $viewingSchedule = $event->viewingSchedule;

        if($event->type == 'new'){
            $administratorRole = Role::where('slug', 'administrator')->first();
            $users = $administratorRole->users;

            ProjectHelper::sendMail(
                $users->lists('email')->all(),
                'New Viewing Schedule: '.$viewingSchedule->property->property_name.' ('.$viewingSchedule->property->listing_code.')',
                'admin.emails.property.new_viewing_schedule',
                [
                    'property' => $viewingSchedule->property,
                    'viewingSchedule' => $viewingSchedule
                ]
            );

            if($viewingSchedule->property->agentList){
                ProjectHelper::sendMail(
                    $viewingSchedule->property->agentList->email,
                    'New Viewing Schedule: '.$viewingSchedule->property->property_name.' ('.$viewingSchedule->property->listing_code.')',
                    'admin.emails.property.agent_new_viewing_schedule',
                    [
                        'property' => $viewingSchedule->property,
                        'viewingSchedule' => $viewingSchedule
                    ]
                );
            }
        }elseif($event->type == 'reschedule'){
            $administratorRole = Role::where('slug', 'administrator')->first();
            $users = $administratorRole->users;

            ProjectHelper::sendMail(
                $users->lists('email')->all(),
                'Reschedule Viewing: '.$viewingSchedule->property->property_name.' ('.$viewingSchedule->property->listing_code.')',
                'admin.emails.property.reschedule_viewing',
                [
                    'property' => $viewingSchedule->property,
                    'viewingSchedule' => $viewingSchedule
                ]
            );

            if($viewingSchedule->property->agentList){
                ProjectHelper::sendMail(
                    $viewingSchedule->property->agentList->email,
                    'Reschedule Viewing: '.$viewingSchedule->property->property_name.' ('.$viewingSchedule->property->listing_code.')',
                    'admin.emails.property.agent_reschedule_viewing',
                    [
                        'property' => $viewingSchedule->property,
                        'viewingSchedule' => $viewingSchedule
                    ]
                );
            }
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
            'GoProp\Listeners\NotificationEventListener@propertyListener'
        );

        $events->listen(
            'GoProp\Events\ViewingScheduleEvent',
            'GoProp\Listeners\NotificationEventListener@viewingScheduleListener'
        );
    }
}
