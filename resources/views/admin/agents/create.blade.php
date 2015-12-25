@extends('admin.layouts.master')

@section('title', 'Create Agent')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.agent.index') }}"><i class="fa fa-users"></i> Agents</a></li>
    <li>Create Agent</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Create Agent</h4>
        </div>

        {!! Form::model($agent,array('route' => 'admin.agent.store', 'class' => 'form-horizontal','files'=>true)) !!}
            @include('admin.agents.create_form')
        {!! Form::close() !!}
    </div>
@endsection