@extends('admin.layouts.master')

@section('title', 'Viewing Schedule by '.$viewingSchedule->user->profile->singleName)

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.viewing_schedule.index') }}"><i class="fa fa-calendar"></i> Viewing Schedules</a></li>
    <li>Choose agent you want to assign this schedule to</li>
@stop

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Choose agent you want to assign this schedule to</h4>
        </div>

        {!! Form::open(['route' => ['admin.viewing_schedule.assign_to_agent', 'id' => $viewingSchedule->id], 'method' => 'POST', 'id' => 'viewing-schedule-assign-form', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('agent', 'Choose Agent', array('class'=>'col-md-2 control-label')) !!}
                <div class="col-md-10">
                    {!! Form::select('agent', ['' => 'Select Agent'] + $agentOptions, [$viewingSchedule->agent_id], ['id' => 'agent', 'class' => 'select-chosen form-control']) !!}
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