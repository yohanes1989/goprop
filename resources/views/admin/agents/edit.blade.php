@extends('admin.layouts.master')

@section('title', 'Edit Agent ('.$agent->profile->singleName.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.member.index') }}"><i class="fa fa-users"></i> Agents</a></li>
    <li>Edit Member ({{ $agent->profile->singleName }})</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Agent ({{ $agent->profile->singleName }})</h4>
        </div>

        {!! Form::model($agent,array('route' => ['admin.agent.update', 'id' => $agent->id], 'class' => 'form-horizontal','files'=>true)) !!}
            @include('admin.agents.create_form')
        {!! Form::close() !!}
    </div>
@endsection