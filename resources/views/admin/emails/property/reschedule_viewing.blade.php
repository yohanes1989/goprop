@extends('emails.master')

@section('email_title', 'Reschedule Viewing for '.$property->property_name.' ('.$property->listing_code.')')

@section('content')
    <p class="lead" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 17px; line-height: 1.6; margin: 0 0 10px; padding: 0;">Hi Admin,</p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">Reschedule viewing is requested with following details:</p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">Listing Name: {{ $property->property_name.' ('.$property->listing_code.')' }}<br/>
        Submitted by: {{ $property->user->profile->singleName }}<br/>
        Phone: {{ $property->user->profile->mobile_phone_number }}<br/>
        Viewing Time: {{ $viewingSchedule->viewing_from->format('d M Y H:i') }}<br/>
        Agent: {{ $property->agentList?$property->agentList->profile->singleName.' ('.$property->agentList->username.')':'Unassigned' }}
    </p>
@stop