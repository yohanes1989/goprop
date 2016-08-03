@extends('admin.layouts.master')

@section('title', 'Edit User ('.$user->profile->singleName.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.user.index') }}"><i class="fa fa-users"></i> Users</a></li>
    <li>Edit Member ({{ $user->profile->singleName }})</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Agent ({{ $user->profile->singleName }})</h4>
        </div>

        {!! Form::model($user,array('route' => ['admin.user.update', 'id' => $user->id], 'class' => 'form-horizontal','files'=>true)) !!}
            @include('admin.users.create_form')
        {!! Form::close() !!}
    </div>
@endsection