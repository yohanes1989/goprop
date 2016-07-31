<?php

namespace GoProp\Helpers;

use GuzzleHttp\Client;
use MailerLiteApi\MailerLite;

class SubscribeHelper
{
    public function subscribe($group, $email, $name=null, $last_name = null, $additional = [])
    {
        $mailerlite = new MailerLite(config('app.mailerlite_api_key'));
        $groupsApi = $mailerlite->groups();

        $data = [
            'email' => $email,
            'fields' => [
                'name' => $name,
                'last_name' => $last_name
            ]
        ];

        $data['fields'] += $additional;

        $subscriber = $data;

        $group_id = config('app.mailerlite_subscriber_groups.'.$group, config('app.mailerlite_subscriber_groups.website_database'));

        $response = $groupsApi->addSubscriber($group_id, $subscriber);
    }
}