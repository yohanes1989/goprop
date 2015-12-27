@extends('frontend.master.layout')

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['frontend.property.schedule_viewing.process', 'id' => $property->id]]) !!}
    <div id="viewing-schedule-form" class="mini-form">
        <header class="entry-header text-center">
            <h3 class="entry-title"><img style="width: 40px; height: auto;" src="{{ asset('assets/frontend/images/icon-user-viewings.png') }}"> {{ trans('property.schedule_viewing.title') }}</h3>
        </header>
        <div class="entry-content clearfix">
            <div class="col-sm-12">
                <div id="viewing-datetime-selector" data-default-date="{{ $defaultDate }}" data-disabled-days="{{ implode(',', $disabledDays) }}">
                    <input type="text" class="form-control" name="viewing_date" />
                </div>

                <div class="viewing-calendar-area">
                    <div class="view-list">
                        <span class="icon bg-blue-light"></span> {{ trans('property.schedule_viewing.legends.today') }}
                    </div>
                    <div class="view-list">
                        <span class="icon bg-green"></span> {{ trans('property.schedule_viewing.legends.property_i_view') }}
                    </div>
                </div>

                <div class="viewing-time">
                    <div class="form-group clearfix">
                        <div class="col-sm-6">
                            {!! Form::label('viewing_time', trans('property.schedule_viewing.label')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-6">
                            {!! Form::select('viewing_time', \GoProp\Models\Property::getViewingTimeLabel(), [$defaultTime], ['class' => 'form-control', 'id' => 'viewing_time']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="entry-detail text-center">
            @if(!$viewingSchedule)
                {!! Form::button(trans('property.schedule_viewing.schedule_btn'), ['type' => 'submit', 'class' => 'btn btn-yellow']) !!}
            @else
                {!! Form::button(trans('property.viewings.change_date'), ['type' => 'submit', 'class' => 'btn btn-yellow']) !!}
            @endif
        </div>
    </div>
    {!! Form::close() !!}
@endsection