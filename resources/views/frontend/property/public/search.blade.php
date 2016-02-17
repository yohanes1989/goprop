@extends('frontend.master.layout')

@section('content')
    <section class="property-search-columns">
        <div class="top-content">
            <div class="container">
                <div class="col-sm-8">
                    <header class="header-area">
                        @if(\Illuminate\Support\Facades\Request::has('for'))
                            <h3 class="entry-title">{!! trans('property.index.for_'.\Illuminate\Support\Facades\Request::input('for').'_title') !!}{!! !empty($citySearch)?' '.trans('property.index.in_city', ['location' => $citySearch]):'' !!}</h3>
                        @else
                            <h3 class="entry-title">{!! trans('property.index.title') !!}{!! !empty($citySearch)?' '.trans('property.index.in_city', ['location' => $citySearch]):'' !!}</h3>
                        @endif
                    </header>
                </div>
                <div class="col-sm-4">
                    <div class="other-link">
                        <a href="{{ route('frontend.property.create') }}"><i class="fa fa-bars"></i> {{ trans('property.index.submit_property') }}</a>
                    </div>
                </div>
            </div>

            @if(!empty($citySearch))
            <div class="maps-container">
                <div class="iframe-responsive iframe-responsive-16x9">
                    <iframe style="pointer-events: none;" src="https://www.google.com/maps/embed/v1/search?key={{ config('app.google_map_embed_key') }}&q={{ urlencode($citySearch) }}" width="800" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
            @endif
        </div>
        <div class="mid-content">
            <div class="container">
                {!! Form::open(['method' => 'GET']) !!}
                <div class="col-sm-9">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            {!! Form::select('search[for]', \GoProp\Models\Property::getForLabel(), [\Illuminate\Support\Facades\Request::input('search.for')], ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-sm-3">
                            {!! Form::text('search[keyword]',  \Illuminate\Support\Facades\Request::input('search.keyword'), ['class' => 'form-control', 'placeholder' => trans('forms.fields.keyword'), 'id' => 'keyword']) !!}
                        </div>
                        <div class="form-group col-sm-2">
                            {!! Form::select('search[province]', ['' => trans('forms.fields.all_provinces')] + \GoProp\Facades\AddressHelper::getProvinces(true), [\Illuminate\Support\Facades\Request::input('search.province')], ['data-default-label' => trans('forms.fields.all_cities'), 'class' => 'form-control form-address-selector-province', 'id' => 'province']) !!}
                        </div>
                        <div class="form-group col-sm-2">
                            {!! Form::select('search[city]', ['' => trans('forms.fields.all_cities')] + \GoProp\Facades\AddressHelper::getCities(\Illuminate\Support\Facades\Request::input('search.province'), true), [\Illuminate\Support\Facades\Request::input('search.city')], ['data-default-label' => trans('forms.fields.all_areas'), 'class' => 'form-control form-address-selector-city', 'id' => 'city']) !!}
                        </div>
                        <div class="form-group col-sm-2">
                            {!! Form::select('search[subdistrict]', ['' => trans('forms.fields.all_areas')] + \GoProp\Facades\AddressHelper::getSubdistricts(\Illuminate\Support\Facades\Request::input('search.city'), true), [\Illuminate\Support\Facades\Request::input('search.subdistrict')], ['class' => 'form-control form-address-selector-subdistrict', 'id' => 'subdistrict']) !!}
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-3">
                            {!! Form::select('search[type]', ['' => trans('forms.fields.all_types')] + \GoProp\Models\PropertyType::getOptions(), [\Illuminate\Support\Facades\Request::input('search.type')], ['class' => 'form-control', 'id' => 'property_type']) !!}
                        </div>
                        <div class="form-group col-sm-3">
                            {!! Form::select('search[rooms]', ['' => trans('forms.fields.min_rooms')] + \GoProp\Models\Property::getBedroomsLabel(), [\Illuminate\Support\Facades\Request::input('search.rooms')], ['class' => 'form-control', 'id' => 'rooms']) !!}
                        </div>
                        <div class="form-group col-sm-6">
                            <div>{{ trans('property.index.price_range') }}: <strong>IDR <span id="price-from">{{ $priceDefaultFrom }}</span> - IDR <span id="price-to">{{ $priceDefaultTo }}</span></strong></div>
                            <input type="text" id="inputPriceRange" name="search[price]" value="" data-slider-min="10000000" data-slider-max="100000000000"
                                   data-slider-step="500000" data-slider-value="[{{ $priceDefaultFrom }},{{ $priceDefaultTo }}]" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 form-submit">
                    {!! Form::hidden('sort', \Illuminate\Support\Facades\Request::get('sort')) !!}
                    <button class="btn btn-yellow btn-submit">{{ trans('property.index.search_property') }}</button>
                </div>
                {!! Form::close() !!}
                <div class="col-xs-12">
                    <hr class="form-divider" />
                </div>
            </div>
        </div>

        <div class="bottom-content">
            <div class="container">
                <div class="col-sm-8 col-md-9">
                    <div class="property-search-wrapper">
                        <header class="header-area">
                            <h3 class="entry-title">{{ trans('property.index.advanced_search', ['count' => $resultCount]) }}</h3>
                            <!--
                            <div class="entry-desc">
                                <p>By logging in, you can save this search and receive instant email notification whenever new properties matching your search are published.</p>
                            </div>
                            -->
                        </header>
                        <div class="entry-detail">
                            <div class="row">
                                <div class="col-sm-3">
                                    {!! Form::open(['method' => 'GET']) !!}
                                    <select name="sort" id="sort" class="form-control">
                                        @foreach($sorts as $idx=>$sort)
                                            <option data-sort-url="{{ route('frontend.property.search', ['sort' => $idx, 'search' => \Illuminate\Support\Facades\Request::get('search')]) }}" {{ ($idx == \Illuminate\Support\Facades\Request::get('sort'))?'selected':'' }} value="{{ $idx }}">{{ $sort }}</option>
                                        @endforeach
                                    </select>
                                    {!! Form::close() !!}
                                </div>
                                <div class="col-sm-7"></div>
                                <div class="col-sm-2 grid-setting">
                                    <!--<a href="" class="active"><i class="fa fa-bars"></i></a>-->
                                    <a href="" class="active"><i class="fa fa-th"></i></a>
                                </div>
                            </div>
                        </div>

                        @include('frontend.property.compare_bar')

                        <div class="propertyItem-list">
                            <div class="row">
                                @foreach($paginator as $property)
                                <div class="propertyItem-child col-sm-6">
                                    <div class="img-wrap">
                                        <a href="{{ route('frontend.property.view', ['for' => $for, 'id' => $property->id]) }}">
                                            <img src="{{ url('images/property_thumbnail/'.$property->getPhotoThumbnail()) }}" class="img-responsive">
                                        </a>
                                    </div>
                                    <header class="entry-header clearfix">
                                        <div class="pull-left">
                                            <h4 class="entry-title"><a href="{{ route('frontend.property.view', ['for' => $for, 'id' => $property->id]) }}">{{ $property->property_name }}</a></h4>
                                            <div class="entry-desc">
                                                {{ trans('property.for.'.$for.'_property_title', ['name' => trans('property.property_type.'.$property->type->slug)]) }}<br/>
                                                {{ $property->subdistrict_name, $property->city_name }}
                                            </div>
                                        </div>

                                        <div class="pull-right user-info">
                                            <ul class="list-unstyled">
                                                @include('frontend.property.includes.shareTo')
                                                @if(\Illuminate\Support\Facades\Auth::check() && $property->user_id != \Illuminate\Support\Facades\Auth::user()->id)
                                                    <li class="{{ $property->isLikedBy(\Illuminate\Support\Facades\Auth::user())?'checked':'' }}"><a href="{{ route(($property->isLikedBy(\Illuminate\Support\Facades\Auth::user())?'frontend.property.unlike':'frontend.property.like'), ['id' => $property->id]) }}"><i class="fa {{ $property->isLikedBy(\Illuminate\Support\Facades\Auth::user())?'fa-heart':'fa-heart-o' }}"></i></a></li>
                                                @endif
                                                <li>
                                                    @if(!\GoProp\Facades\PropertyCompareHelper::isAddedToComparison($property))
                                                    <a href="{{ route('frontend.property.compare.add', ['id' => $property->id]) }}"><i class="fa fa-plus"></i></a>
                                                    @else
                                                    <a href="{{ route('frontend.property.compare.remove', ['id' => $property->id]) }}"><i class="fa fa-minus"></i></a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </header>
                                    <div class="entry-content clearfix">
                                        <div class="pull-left">
                                            @if($property->isResidential())
                                            <div class="featureChild">
                                                <div class="name">{{ $property->rooms }}</div>
                                                <div class="desc">{{ trans_choice('property.index.bedrooms', $property->rooms) }}</div>
                                            </div>
                                            <div class="featureChild">
                                                <div class="name">{{ $property->bathrooms }}</div>
                                                <div class="desc">{{ trans_choice('property.index.bathrooms', $property->bathrooms) }}</div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="pull-right">
                                            <h3 class="entry-price">
                                                @include('frontend.property.includes.price')
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @include('frontend.master.pagination')
                    </div>
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="widget-child">
                        @include('frontend.includes.login_sidebar')
                    </div>

                    <div class="widget-child">
                        @include('frontend.includes.call_request_sidebar')
                    </div>

                    <div class="widget-child">
                        @include('frontend.includes.keyword_search')
                    </div>
                    <div class="widget-child">
                        @include('frontend.includes.price_saving_sidebar')
                    </div>
                    <div class="widget-child">
                        @include('frontend.includes.exclusive_properties')
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>
@endsection