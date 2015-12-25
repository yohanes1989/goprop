@extends('frontend.account.logged_in.layout')

@section('content')
    <div class="top-navigation">
        <div class="row">
            <div class="col-sm-10">
                <div class="menu-preview">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('frontend.property.view', ['for' => $model->getViewFor(), 'id' => $model->id, 'preview' => TRUE, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}"><img src="{{ asset('assets/frontend/images/property-preview.png') }}" alt="" /> {{ trans('property.create.preview_property') }}</a></li>
                        <li><a href="#"><img src="{{ asset('assets/frontend/images/property-disable.png') }}" alt="" /> {{ trans('property.create.disable_property') }}</a></li>
                    </ul>
                </div>
                <div class="form-wizard-menu">
                    <ul class="list-unstyled">
                        <li class="active"><a href="{{ route('frontend.property.edit', ['id' => $model->id]) }}">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.main_details') }}</span>
                            </a></li>
                        <li class="current"><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.property_details') }}</span>
                            </a></li>
                        <li><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.map') }}</span>
                            </a></li>
                        <li><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.photos') }}</span>
                            </a></li>
                        <li><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.floorplan') }}</span>
                            </a></li>
                        <li><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.packages') }}</span>
                            </a></li>
                    </ul>
                    <div class="form-wizard-progressbar">
                        <div class="form-wizard-bars" style="width: 25%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10">
            <header class="header-area">
                <h3 class="entry-title">{!! trans('property.main_details.page_title', ['title' => $model->property_name]) !!}</h3>
            </header>
            <div class="row">
                <div class="col-xs-12">
                    <header class="header-area">
                        <h4 class="entry-title">{{ trans('property.main_details.page_subtitle') }}</h4>
                    </header>
                    <div class="entry-content">
                        <p>{{ trans('property.main_details.body_copy') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="register-form-wrapper">
                    {!! Form::model($model, ['route' => ['frontend.property.details.process', 'id' => $model->id]]) !!}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                <div class="col-xs-12">
                                    {!! Form::label('land_size', trans('forms.fields.property.land_size')) !!}
                                </div>
                                <div class="col-xs-12">
                                    {!! Form::text('land_size', null, ['class' => 'form-control', 'id' => 'land_size']) !!}
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-xs-12">
                                    {!! Form::label('building_size', trans('forms.fields.property.building_size')) !!}
                                </div>
                                <div class="col-xs-12">
                                    {!! Form::text('building_size', null, ['class' => 'form-control', 'id' => 'building_size']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                <div class="col-xs-12">
                                    {!! Form::label('floors', trans('forms.fields.property.floors')) !!}
                                </div>
                                <div class="col-xs-12">
                                    {!! Form::select('floors', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getFloorsLabel(), null, ['class' => 'form-control', 'id' => 'floors']) !!}
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-xs-12">
                                    {!! Form::label('certificate', trans('forms.fields.property.certificate')) !!}
                                </div>
                                <div class="col-xs-12">
                                    {!! Form::select('certificate', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getCertificateLabel(), null, ['class' => 'form-control', 'id' => 'certificate']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <header class="header-area">
                            <h4 class="entry-title">{{ trans('forms.fields.short_description') }}</h4>
                        </header>
                        <div class="entry-content">
                            <p>{{ trans('property.main_details.short_description_hint') }}</p>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group clearfix">
                            {!! Form::label('description', trans('forms.fields.summary')) !!} <sup class="text-danger">*</sup>
                            <div class="textarea-group">
                                <div class="textarea-count"><span>300</span> {{ trans('forms.fields.words_remaining') }}</div>
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 8, 'max' => 300]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <header class="header-area">
                            <h4 class="entry-title">{{ trans('forms.fields.virtual_tour') }}</h4>
                        </header>
                        <div class="entry-content">
                            <p>{{ trans('property.main_details.virtual_tour_hint') }}</p>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group clearfix">
                            {!! Form::label('virtual_tour_url', trans('forms.fields.property.virtual_tour_url')) !!}
                            {!! Form::text('virtual_tour_url', null, ['class' => 'form-control', 'id' => 'virtual_tour_url']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <hr class="form-divider" />
                    </div>

                    <div class="col-xs-4">
                        <a href="{{ route('frontend.property.packages', ['id' => $model->id]) }}" class="btn btn-yellow">{{ trans('forms.skip_package_btn') }}</a>
                    </div>
                    <div class="col-xs-4 text-center">
                        {!! Form::button(trans('forms.save_information_btn'), ['name' => 'action', 'value' => 'save_information', 'type' => 'submit', 'class' => 'btn btn-yellow']) !!}
                    </div>
                    <div class="col-xs-4 text-right">
                        {!! Form::button(trans('forms.save_continue_btn'), ['name' => 'action', 'value' => 'save_continue', 'type' => 'submit', 'class' => 'btn btn-yellow']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
@endsection