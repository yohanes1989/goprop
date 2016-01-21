@extends('admin.layouts.master')

@section('title', 'Viewing Schedule by '.$viewingSchedule->user->profile->singleName.' quick edit')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('agent.viewing_schedule.index') }}"><i class="fa fa-calendar"></i> Viewing Schedules</a></li>
    <li>{{ 'Viewing Schedule by '.$viewingSchedule->user->profile->singleName.' quick edit' }}</li>
@stop

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>{{ 'Viewing Schedule by '.$viewingSchedule->user->profile->singleName.' quick edit' }}</h4>
        </div>

        {!! Form::model($viewingSchedule, ['route' => ['agent.viewing_schedule.quick_edit', 'id' => $viewingSchedule->id], 'method' => 'POST', 'id' => 'viewing-schedule-quick-edit-form', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            {!! Form::label('property', 'Property', array('class'=>'col-md-2 control-label')) !!}
            <div class="col-md-10">
                {!! Form::text('property', $viewingSchedule->property->property_name.' ('.$viewingSchedule->property->type->name.'), '.\GoProp\Facades\AddressHelper::getAddressLabel($viewingSchedule->property->city, 'city').', '.\GoProp\Facades\AddressHelper::getAddressLabel($viewingSchedule->property->subdistrict, 'subdistrict'), ['id' => 'property', 'class' => 'form-control', 'disabled' => TRUE]) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('viewing_from', 'Viewing From', array('class'=>'col-md-2 control-label')) !!}
            <div class="col-md-10">
                <div class="input-datetimepicker input-group date">
                    {!! Form::text('viewing_from', $viewingSchedule->viewing_from->format('Y-m-d H:i'), ['readonly' => TRUE, 'id' => 'viewing_from', 'class' => 'form-control']) !!}
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('viewing_until', 'Viewing Until', array('class'=>'col-md-2 control-label')) !!}
            <div class="col-md-10">
                <div class="input-datetimepicker input-group date">
                    {!! Form::text('viewing_until', $viewingSchedule->viewing_until->format('Y-m-d H:i'), ['readonly' => TRUE, 'id' => 'viewing_until', 'class' => 'form-control']) !!}
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('status', 'Status', array('class'=>'col-md-2 control-label')) !!}
            <div class="col-md-10">
                {!! Form::select('status', ['' => 'Select Status'] + \GoProp\Models\ViewingSchedule::getStatusLabel(), null, ['id' => 'status', 'class' => 'select-chosen form-control']) !!}
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