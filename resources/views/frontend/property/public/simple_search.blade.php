@extends('frontend.master.layout')

@section('content')
    {!! Form::open(['method' => 'GET', 'route' => 'frontend.property.search']) !!}
    <div id="property-search-form" class="mini-form">
        <header class="entry-header text-center">
            <h3 class="entry-title"><img src="{{ asset('assets/frontend/images/icon-property-search.png') }}"> {{ trans('property.index.property_search') }}</h3>
        </header>
        <div class="entry-content clearfix">
            <div class="col-sm-3">
                <label>{{ trans('property.index.im_looking_for') }}</label>
                <div class="radio-custom">
                    {!! Form::radio('search[for]', 'sell', true, ['id' => 'for-sell']) !!}
                    {!! Form::label('for-sell', trans('property.for.sell')) !!}

                    {!! Form::radio('search[for]', 'rent', false, ['id' => 'for-rent']) !!}
                    {!! Form::label('for-rent', trans('property.for.rent')) !!}
                </div>
            </div>
            <div class="col-sm-3">
                {!! Form::label('province', trans('forms.fields.province')) !!}
                {!! Form::select('search[province]', ['' => trans('forms.fields.all_provinces')] + \GoProp\Facades\AddressHelper::getProvinces(true), null, ['data-default-label' => trans('forms.fields.all_cities'), 'class' => 'form-control form-address-selector-province', 'id' => 'province']) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label('city', trans('forms.fields.city')) !!}
                {!! Form::select('search[city]', ['' => trans('forms.fields.all_cities')] + \GoProp\Facades\AddressHelper::getCities(\Illuminate\Support\Facades\Request::get('province'), true), null, ['data-default-label' => trans('forms.fields.all_areas'), 'class' => 'form-control form-address-selector-city', 'id' => 'city']) !!}
            </div>
            <div class="col-sm-3">
                {!! Form::label('subdistrict', trans('forms.fields.area')) !!}
                {!! Form::select('search[subdistrict]', ['' => trans('forms.fields.all_areas')] + \GoProp\Facades\AddressHelper::getSubdistricts(\Illuminate\Support\Facades\Request::get('city'), true), null, ['class' => 'form-control form-address-selector-subdistrict', 'id' => 'subdistrict']) !!}
            </div>
        </div>
        <div class="entry-detail text-center">
            {!! Form::button(trans('forms.search_btn'), ['type' => 'submit', 'class' => 'btn btn-yellow']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection