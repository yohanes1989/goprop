@extends('frontend.account.logged_in.layout')

@section('content')
    <div class="top-navigation">
        <div class="row">
            <div class="col-md-10">
                @include('frontend.property.includes.edit_top_bar')
                <div class="form-wizard-menu">
                    <ul class="list-unstyled">
                        <li class="active"><a href="#">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.main_details') }}</span>
                            </a></li>
                        <li class="active"><a href="#">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.property_details') }}</span>
                            </a></li>
                        <li class="active"><a href="#">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.map') }}</span>
                            </a></li>
                        <li class="active"><a href="#">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.photos') }}</span>
                            </a></li>
                        <li class="active"><a href="#">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.floorplan') }}</span>
                            </a></li>
                        <li class="active"><a href="#">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.packages') }}</span>
                            </a></li>
                    </ul>
                    <div class="form-wizard-progressbar">
                        <div class="form-wizard-bars" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <div class="register-form-wrapper">
                <header class="header-area">
                    <h3 class="entry-title">{!! trans('property.success.page_title') !!}</h3>
                </header>
                <div class="entry-content">
                    <p>{{ trans('property.success.body_copy', ['email' => 'marketing@goprop.co.id', 'phone' => '+62 878 8733 2268']) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection