@extends('admin.layouts.master')

@section('title', 'Edit Referral Information')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.referrals.index') }}"><i class="fa fa-bell-o"></i> My Referrals</a></li>
    <li>Edit Referral Information</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Referral Information</h4>
        </div>

        {!! Form::model($referralInformation,array('route' => ['admin.referrals.update', 'id' => $referralInformation->id], 'class' => 'form-horizontal')) !!}
            @include('admin.referrals.create_form')
        {!! Form::close() !!}
    </div>
@endsection