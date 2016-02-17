@extends('frontend.emails.master')

@section('email_title', 'Password Reset')

@section('content')
    <p class="lead" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 17px; line-height: 1.6; margin: 0 0 10px; padding: 0;">Password Reset</p>

    <?php $resetLink = route('frontend.account.reset', ['token' => $token]); ?>
    <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-weight: normal; font-size: 14px; line-height: 1.6; margin: 0 0 10px; padding: 0;">Click here to reset your password: <a href="{{ $resetLink }}" target="_blank">{{ $resetLink }}</p>
@stop
