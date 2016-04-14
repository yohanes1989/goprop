@extends('frontend.master.layout')

@section('content')
    <section class="property-search-columns">
        <div class="top-content">
            <div class="container">
                <div class="col-sm-12">
                    <header class="header-area">
                        @if(\Illuminate\Support\Facades\Request::has('for'))
                            <h3 class="entry-title">{!! trans('property.index.for_'.\Illuminate\Support\Facades\Request::input('for').'_title') !!}{!! !empty($citySearch)?' '.trans('property.index.in_city', ['location' => $citySearch]):'' !!}</h3>
                        @else
                            <h3 class="entry-title">{!! trans('property.index.title') !!}{!! !empty($citySearch)?' '.trans('property.index.in_city', ['location' => $citySearch]):'' !!}</h3>
                        @endif
                    </header>
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
                {!! Form::open(['method' => 'GET', 'data-collapsible' => trans('property.index.search_filter')]) !!}
                <div class="col-sm-9">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            {!! Form::select('search[for]', ['all' => trans('forms.fields.all')] + \GoProp\Models\Property::getForLabel(), [\Illuminate\Support\Facades\Request::input('search.for')], ['class' => 'form-control']) !!}
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
                            {!! Form::select('search[rooms]', ['' => trans('forms.fields.min_rooms')] + \GoProp\Models\Property::getBedroomsLabel(), \Illuminate\Support\Facades\Request::input('search.rooms', null), ['class' => 'form-control', 'id' => 'rooms']) !!}
                        </div>
                        <div class="form-group col-sm-6">
                            <div>{{ trans('property.index.price_range') }}: <strong>IDR <span id="price-from">{{ $priceDefaultFrom }}</span> - IDR <span id="price-to">{{ $priceDefaultTo }}</span></strong></div>
                            <input type="text" id="inputPriceRange" name="search[price]" value="" data-min="50000000" data-max="100000000000"
                                   data-step="50000000" data-from="{{ $priceDefaultFrom }}" data-to="{{ $priceDefaultTo }}" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 form-submit">
                    {!! Form::hidden('sort', \Illuminate\Support\Facades\Request::get('sort')) !!}
                    <button class="btn btn-yellow btn-submit">{{ trans('property.index.search_property') }}</button>
                </div>

                <div class="col-xs-12">
                    <hr class="form-divider" />
                </div>
                {!! Form::close() !!}
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
                                    <!--<a href="" class="active"><i class="fa fa-th"></i></a>-->
                                </div>
                            </div>
                        </div>

                        @include('frontend.property.compare_bar')

                        <div class="propertyItem-list">
                            @foreach($paginator as $property)
                            <div class="propertyItem-child row">
                                <div class="col-sm-5">
                                    <div class="img-wrap">
                                        <a href="{{ route('frontend.property.view', ['id' => $property->id]) }}">
                                            <img src="{{ url('images/property_thumbnail/'.$property->getPhotoThumbnail()) }}" class="img-responsive">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <header class="entry-header clearfix">
                                        <h4 class="entry-price">
                                            @include('frontend.property.includes.price')
                                        </h4>

                                        <h4 class="entry-title"><a href="{{ route('frontend.property.view', ['id' => $property->id]) }}">{{ $property->property_name }}</a></h4>

                                        <div class="entry-desc">
                                            {{ trans('property.for.'.$property->getViewFor().'_property_title', ['name' => trans('property.property_type.'.$property->type->slug)]) }}
                                        </div>
                                    </header>

                                    <div class="entry-content">
                                        @if(!empty($property->land_size+0))
                                        <div class="featureChild">
                                            <span class="name">{{ trans('forms.fields.property.land_size') }}:</span>
                                            <span class="desc">{!! $property->land_size.' m<sup>2</sup>' !!}</span>
                                        </div>
                                        @endif

                                        @if($property->land_dimension['length'] && $property->land_dimension['width'])
                                        <div class="featureChild">
                                            <span class="name">{{ trans('forms.fields.property.land_dimension') }}:</span>
                                            <span class="desc">{{ $property->landDimensionWithUnit }}</span>
                                        </div>
                                        @endif

                                        @if(!empty($property->building_size+0))
                                        <div class="featureChild">
                                            <span class="name">{{ trans('forms.fields.property.building_size') }}:</span>
                                            <span class="desc">{!! $property->building_size.' m<sup>2</sup>' !!}</span>
                                        </div>
                                        @endif

                                        @if($property->building_dimension['length'] && $property->building_dimension['width'])
                                        <div class="featureChild">
                                            <span class="name">{{ trans('forms.fields.property.building_dimension') }}:</span>
                                            <span class="desc">{{ $property->buildingDimensionWithUnit }}</span>
                                        </div>
                                        @endif

                                        @if($property->isResidential())
                                                <div class="clearfix"></div>

                                            <div class="featureChild">
                                                <span class="name">{{ $property->rooms }}</span>
                                                <span class="desc">{{ trans_choice('property.index.bedrooms', $property->rooms) }}</span>
                                            </div>
                                            <div class="featureChild">
                                                <span class="name">{{ $property->bathrooms }}</span>
                                                <span class="desc">{{ trans_choice('property.index.bathrooms', $property->bathrooms) }}</span>
                                            </div>
                                        @endif
                                            <div class="clearfix"></div>

                                        <div class="user-info">
                                            <ul class="list-unstyled">
                                                @include('frontend.property.includes.shareTo')
                                                <li class="{{ $property->isLikedBy(\Illuminate\Support\Facades\Auth::user())?'checked':'' }}"><a data-toggle="tooltip" title="{{ $property->isLikedBy(\Illuminate\Support\Facades\Auth::user())?trans('property.buttons.unlike'):trans('property.buttons.like') }}" href="{{ route('frontend.property.toggle_like', ['id' => $property->id]) }}" class="toggle-like"><i class="fa {{ $property->isLikedBy(\Illuminate\Support\Facades\Auth::user())?'fa-heart':'fa-heart-o' }}"></i></a></li>
                                                <li>
                                                    @if(!\GoProp\Facades\PropertyCompareHelper::isAddedToComparison($property))
                                                        <a data-toggle="tooltip" title="{{ trans('property.property_comparison.tooltip_compare') }}" href="{{ route('frontend.property.compare.add', ['id' => $property->id]) }}"><i class="fa fa-plus"></i></a>
                                                    @else
                                                        <a data-toggle="tooltip" title="{{ trans('property.property_comparison.tooltip_uncompare') }}" href="{{ route('frontend.property.compare.remove', ['id' => $property->id]) }}"><i class="fa fa-minus"></i></a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @include('frontend.master.pagination')
                    </div>
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="widget-child">
                        <a href="{{ route('frontend.property.create') }}"><i class="fa fa-plus"></i> {{ trans('property.index.submit_property') }}</a>
                    </div>

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