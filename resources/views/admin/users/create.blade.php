@extends('admin.layouts.master')

@section('title', 'Create User')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.user.index') }}"><i class="fa fa-users"></i> Users</a></li>
    <li>Create User</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Create User</h4>
        </div>

        {!! Form::model($user,array('route' => 'admin.user.store', 'class' => 'form-horizontal','files'=>true)) !!}
            @include('admin.users.create_form')
        {!! Form::close() !!}
    </div>
@endsection