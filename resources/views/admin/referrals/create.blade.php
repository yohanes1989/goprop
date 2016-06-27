@extends('admin.layouts.master')

@section('title', 'Add Referral Information')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.referrals.index') }}"><i class="fa fa-bell-o"></i> My Referrals</a></li>
    <li>Add Referral Information</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Add Referral Information</h4>
        </div>

        {!! Form::model($referralInformation,array('route' => 'admin.referrals.store', 'class' => 'form-horizontal')) !!}
            @include('admin.referrals.create_form')
        {!! Form::close() !!}
    </div>
@endsection