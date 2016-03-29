@extends('admin.layouts.master')

@section('title', 'Agent of Property '.$property->property_name)

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.property.index') }}"><i class="fa fa-home"></i> Properties</a></li>
    <li>Choose agent you want to assign this property to</li>
@stop

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Choose agent you want to assign this property to</h4>
        </div>

        {!! Form::open(['route' => ['admin.property.assign_to_agent', 'id' => $property->id], 'method' => 'POST', 'id' => 'conversation-assign-form', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('agent', 'Choose Agent', array('class'=>'col-md-2 control-label')) !!}
                <div class="col-md-10">
                    {!! Form::select('agent', ['' => 'Select Agent'] + $agentOptions, $property->agentList?[$property->agentList->id]:[], ['id' => 'agent', 'class' => 'select-chosen form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    {!! Form::hidden('backUrl', $backUrl) !!}
                {!! Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@stop