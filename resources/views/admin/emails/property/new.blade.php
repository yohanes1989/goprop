@extends('emails.master')

@section('email_title', 'New Property')

@section('content')
    <p class="lead" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 17px; line-height: 1.6; margin: 0 0 10px; padding: 0;">Hi Admin,</p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">There is a new property with following details:</p>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">{{ trans('property.for.'.$property->getViewFor().'_property_title', ['name' => trans('property.property_type.'.$property->type->slug)]) }}<br/>
    Listing Name: {{ $property->property_name }}<br/>
    Submitted by: {{ $property->user->profile->singleName }}<br/>
    Location: {{ AddressHelper::getAddressLabel($property->subdistrict, 'subdistrict').', '.AddressHelper::getAddressLabel($property->city, 'city') }}
    </p>

    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;"><a href="{{ route('admin.property.edit', ['id' => $property->id]) }}">Manage this property.</a></p>
@stop