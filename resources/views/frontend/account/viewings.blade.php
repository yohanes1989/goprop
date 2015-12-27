@extends('frontend.account.logged_in.layout')

@section('content')
    <div class="user-content-begin">
        <div class="row">
            <div class="col-sm-12">
                <header class="header-area">
                    <h3 class="entry-title">{{ trans('property.viewings.title') }}</h3>
                </header>
                <div class="row">
                    <div class="col-sm-6">
                        <div id="viewing-calendar"></div>
                        <div class="viewing-calendar-area">
                            <div class="view-list">
                                <span class="icon bg-yellow"></span> {{ trans('property.viewings.view_of_my_property') }}
                            </div>
                            <div class="view-list">
                                <span class="icon bg-green"></span> {{ trans('property.viewings.properties_i_view') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        @foreach($viewingSchedules as $viewingSchedule)
                        <div class="property-schedule clearfix">
                            <div class="icon">
                                <img src="{{ asset('assets/frontend/images/icon-user-viewings.png') }}" alt="">
                            </div>
                            <div class="property-detail">
                                <div class="img-wrap">
                                    <img src="{{ url('images/property_thumbnail/'.$viewingSchedule->property->getPhotoThumbnail()) }}" alt="" class="img-responsive">
                                </div>
                                <header class="entry-header">
                                    <h3 class="entry-title">{{ $viewingSchedule->property->property_name }}</h3>
                                    <h5 class="entry-desc">{{ trans('property.viewings.scheduled_label') }}:</h5>
                                    <h5 class="entry-desc"><strong>{{ $viewingSchedule->viewing_from->format('D, d M Y  H:i') }}</strong></h5>
                                </header>
                                <div class="entry-button">
                                    <a href="{{ route('frontend.property.schedule_viewing', ['id' => $viewingSchedule->property->id]) }}" class="ajax_popup fancybox.ajax btn btn-yellow">{{ trans('property.viewings.change_date') }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection