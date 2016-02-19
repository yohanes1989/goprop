@extends('admin.layouts.master')

@section('title', 'Assign conversation regarding '.$property->property_name)

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.customer_inquiry.index') }}"><i class="fa fa-comments"></i> Customer Inquiry</a></li>
    <li>Choose agent you want to assign this conversation to</li>
@stop

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Choose agent you want to assign this conversation to</h4>
        </div>

        {!! Form::open(['route' => ['admin.customer_inquiry.assign_to_agent', 'id' => $conversation->id], 'method' => 'POST', 'id' => 'conversation-assign-form', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('agent', 'Choose Agent', array('class'=>'col-md-2 control-label')) !!}
                <div class="col-md-10">
                    {!! Form::select('agent', ['' => 'Select Agent'] + $agentOptions, $conversation->recipient?[$conversation->recipient->id]:[], ['id' => 'agent', 'class' => 'select-chosen form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                {!! Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@stop