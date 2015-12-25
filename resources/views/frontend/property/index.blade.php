@extends('frontend.account.logged_in.layout')

@section('content')
    <div class="user-content-begin">
        <div class="col-sm-10">
            <!-- Custom Tabs -->
            <div class="custom-tabs">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="{{ $for == 'sell'?'active':'' }}">
                        <a href="{{ route('frontend.property.index', ['for' => 'sell']) }}">{{ trans('property.my_properties.property_i_sell') }}</a>
                    </li>
                    <li class="{{ $for == 'rent'?'active':'' }}">
                        <a href="{{ route('frontend.property.index', ['for' => 'lease']) }}">{{ trans('property.my_properties.property_i_lease') }}</a>
                    </li>
                    <li class="{{ $for == 'liked'?'active':'' }}">
                        <a href="{{ route('frontend.property.index', ['for' => 'liked']) }}">{{ trans('property.my_properties.property_interested') }}</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="row propertyItem-list">
                            @include('frontend.property.index.'.$for)
                        </div>
                        <div class="col-xs-12 text-center">
                            @include('frontend.master.pagination', ['paginator' => $properties])
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
@endsection