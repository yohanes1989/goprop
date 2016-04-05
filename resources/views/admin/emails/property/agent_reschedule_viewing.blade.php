@extends('emails.master')

@section('email_title', 'New Viewing Schedule for '.$property->property_name.' ('.$property->listing_code.')')

@section('content')
    <p class="lead" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 17px; line-height: 1.6; margin: 0 0 10px; padding: 0;">Hi {{ $property->agentList->profile->singleName }},</p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">Reschedule viewing is requested with following details:</p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">Listing Name: {{ $property->property_name.' ('.$property->listing_code.')' }}<br/>
        Submitted by: {{ $property->user->profile->singleName }}<br/>
        Phone: {{ $property->user->profile->mobile_phone_number }}<br/>
        Viewing Time: {{ $viewingSchedule->viewing_from->format('d M Y H:i') }}
    </p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;"><a href="{{ route('agent.viewing_schedule.index') }}">Please manage this viewing here.</a></p>
@stop