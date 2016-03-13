@extends('frontend.master.layout')

@section('content')
    <section class="property-search-columns">
        <div class="mid-content">
            <div class="container">
                <div class="col-xs-12">
                    <div class="compare-outer-wrapper">
                        <header class="header-area">
                            <h3 class="entry-title">{{ trans('property.property_comparison.title') }}</h3>
                        </header>
                        <div class="compare-list propertyItem-list row">
                            <div class="compare-child propertyItem-child col-md-3 col-sm-6">
                                <div class="compare-top"></div>
                                <div class="compare-bottom">
                                    <table class="table table-none">
                                        <tbody>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.property_type') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.province') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.city') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.area') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.rooms') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.bathrooms') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.carport_size') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.garage_size') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.building_size') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.building_dimension') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.land_size') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.land_dimension') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.floors') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.certificate') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.remark') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @foreach($properties as $property)
                            <div class="compare-child propertyItem-child col-md-3 col-sm-12">
                                <div class="compare-top">
                                    <div class="img-wrap">
                                        <a href="{{ route('frontend.property.view', ['id' => $property->id]) }}"><img src="{{ url('images/property_thumbnail/'.$property->getPhotoThumbnail()) }}" class="img-responsive"></a>
                                        <div class="user-info">
                                            <ul class="list-unstyled">
                                                @include('frontend.property.includes.shareTo', ['for' => $property->getViewFor()])
                                                    @if(\Illuminate\Support\Facades\Auth::check() && $property->user_id != \Illuminate\Support\Facades\Auth::user()->id)
                                                    <li class="{{ $property->isLikedBy(\Illuminate\Support\Facades\Auth::user())?'checked':'' }}"><a data-toggle="tooltip" title="{{ $property->isLikedBy(\Illuminate\Support\Facades\Auth::user())?trans('property.buttons.unlike'):trans('property.buttons.like') }}" href="{{ route('frontend.property.toggle_like', ['id' => $property->id]) }}" class="toggle-like"><i class="fa {{ $property->isLikedBy(\Illuminate\Support\Facades\Auth::user())?'fa-heart':'fa-heart-o' }}"></i></a></li>
                                                    @endif
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
                                    <div class="container">
                                        <header class="entry-header clearfix">
                                            <div class="pull-left">
                                                <h4 class="entry-title"><a href="{{ route('frontend.property.view', ['id' => $property->id]) }}">{{ $property->property_name }}</a></h4>
                                            </div>
                                        </header>
                                        <div class="entry-content clearfix">
                                            <h3 class="entry-price">@include('frontend.property.includes.price', ['for' => $property->getViewFor()])</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="compare-bottom">
                                    <table class="table table-none">
                                        <tbody>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.property_type') }}:</strong>&nbsp;{{ trans('property.property_type.'.$property->type->slug) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.province') }}:</strong>&nbsp;{{ \GoProp\Facades\AddressHelper::getAddressLabel($property->province, 'province') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.city') }}:</strong>&nbsp;{{ \GoProp\Facades\AddressHelper::getAddressLabel($property->city, 'city') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.area') }}:</strong>&nbsp;{{ \GoProp\Facades\AddressHelper::getAddressLabel($property->subdistrict, 'subdistrict') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.rooms') }}: </strong>&nbsp;{{ $property->rooms }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.bathrooms') }}:</strong>&nbsp;{{ $property->bathrooms }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.carport_size') }}:</strong>&nbsp;{{ $property->carport_size?$property->carport_size:'-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.garage_size') }}:</strong>&nbsp;{{ $property->garage_size?$property->garage_size:'-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.building_size') }}:</strong>&nbsp;{!! !empty($property->building_size+0)?$property->building_size.' m<sup>2</sup>':'-' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.building_dimension') }}:</strong>&nbsp;{!! ($property->building_dimension['length'] && $property->building_dimension['width'])?$property->buildingDimensionWithUnit:'-' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.land_size') }}:</strong>&nbsp;{!! !empty($property->land_size+0)?$property->land_size.' m<sup>2</sup>':'-' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.land_dimension') }}:</strong>&nbsp;{!! ($property->land_dimension['width'] && $property->land_dimension['length'])?$property->landDimensionWithUnit:'-' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.floors') }}:</strong>&nbsp;{{ !empty(ceil($property->floors))?$property->floors:'' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.certificate') }}:</strong>&nbsp;{{ $property->certificate?trans('property.certificate.'.$property->certificate):'-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.remark') }}:</strong>&nbsp;{{ $property->short_note }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>
@endsection