@extends('admin.layouts.master')

@section('title', 'Create Member')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.member.index') }}"><i class="fa fa-user"></i> Members</a></li>
    <li>Create Member</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Create Member</h4>
        </div>

        {!! Form::model($member,array('route' => 'admin.member.store', 'class' => 'form-horizontal','files'=>true)) !!}
            @include('admin.members.create_form')
        {!! Form::close() !!}
    </div>
@endsection