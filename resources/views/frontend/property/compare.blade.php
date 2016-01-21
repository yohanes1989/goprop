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
                                                <td>{{ trans('forms.fields.property.building_size') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.floors') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.land_size') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.rooms') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.bathrooms') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.parking') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('forms.fields.property.certificate') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @foreach($properties as $property)
                            <div class="compare-child propertyItem-child col-md-3 col-sm-12">
                                <div class="compare-top">
                                    <div class="img-wrap">
                                        <a href="{{ route('frontend.property.view', ['for' => $property->getViewFor(), 'id' => $property->id]) }}"><img src="{{ url('images/property_thumbnail/'.$property->getPhotoThumbnail()) }}" class="img-responsive"></a>
                                        <div class="user-info">
                                            <ul class="list-unstyled">
                                                @include('frontend.property.includes.shareTo', ['for' => $property->getViewFor()])
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
                                    </div>
                                    <div class="row">
                                        <header class="entry-header clearfix">
                                            <div class="pull-left">
                                                <h4 class="entry-title"><a href="{{ route('frontend.property.view', ['for' => $property->getViewFor(), 'id' => $property->id]) }}">{{ $property->property_name }}</a></h4>
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
                                                <td><strong>{{ trans('forms.fields.property.building_size') }}:</strong>&nbsp;{!! !empty($property->building_size)?$property->building_size.' m<sup>2</sup>':'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.floors') }}:</strong>&nbsp;{{ !empty(ceil($property->floors))?$property->floors:'' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.land_size') }}:</strong>&nbsp;{!! !empty($property->land_size)?$property->land_size.' m<sup>2</sup>':'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.rooms') }}: </strong>&nbsp;{{ $property->rooms }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.bathrooms') }}:</strong>&nbsp;{{ $property->bathrooms }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.parking') }}:</strong>&nbsp;
                                                    {{ trans('property.parking.'.$property->parking) }}
                                                    @if($property->parking == 'garage')
                                                        <em>{{ trans('forms.fields.property.garage_size') }}: {{ $property->garage_size }}</em>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('forms.fields.property.certificate') }}:</strong>&nbsp;{{ !empty($property->certificate)?trans('property.certificate.'.$property->certificate):'' }}</td>
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