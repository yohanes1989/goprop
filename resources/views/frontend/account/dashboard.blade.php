@extends('frontend.account.logged_in.layout')

@section('content')
    <p>{{ trans('account.interface.greeting') }} {{ Auth::user()->getName() }}</p>

    @if($sellProperties->count() > 0 || $leaseProperties->count() > 0 || $likedProperties->count() > 0)
    <!-- Custom Tabs -->
    <div class="custom-tabs">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            @if($sellProperties->count() > 0)
                <li role="presentation"><a href="#property-sell" aria-controls="sell-property" role="tab" data-toggle="tab">{{ trans('property.my_properties.property_i_sell') }}</a></li>
            @endif

            @if($leaseProperties->count() > 0)
                <li role="presentation"><a href="#property-lease" aria-controls="lease-property" role="tab" data-toggle="tab">{{ trans('property.my_properties.property_i_lease') }}</a></li>
            @endif

            @if($likedProperties->count() > 0)
                <li role="presentation"><a href="#property-liked" aria-controls="liked-property" role="tab" data-toggle="tab">{{ trans('property.my_properties.property_interested') }}</a></li>
            @endif
        </ul>

        <div class="tab-content">
            @if($sellProperties->count() > 0)
                <div role="tabpanel" class="tab-pane" id="property-sell">
                    <div class="propertyItem-list">
                        @foreach($sellProperties as $sellProperty)
                            @include('frontend.property.index.row', ['for' => 'sell', 'property' => $sellProperty])
                        @endforeach
                    </div>
                    <div class="col-xs-12 text-center">
                        <a href="{{ route('frontend.property.index', ['for' => 'sell']) }}" class="btn btn-yellow"><i class="fa fa-plus"></i> {{ trans('property.my_properties.more_results') }}</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endif

            @if($leaseProperties->count() > 0)
                <div role="tabpanel" class="tab-pane" id="property-lease">
                    <div class="propertyItem-list">
                        @foreach($leaseProperties as $leaseProperty)
                            @include('frontend.property.index.row', ['for' => 'rent', 'property' => $leaseProperty])
                        @endforeach
                    </div>

                    <div class="col-xs-12 text-center">
                        <a href="{{ route('frontend.property.index', ['for' => 'lease']) }}" class="btn btn-yellow"><i class="fa fa-plus"></i> {{ trans('property.my_properties.more_results') }}</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endif

            @if($likedProperties->count() > 0)
                <div role="tabpanel" class="tab-pane" id="property-liked">
                    <div class="propertyItem-list">
                        @foreach($likedProperties as $likedProperty)
                            @include('frontend.property.index.row', ['for' => $likedProperty->getViewFor(), 'property' => $likedProperty])
                        @endforeach
                    </div>
                    <div class="col-xs-12 text-center">
                        <a href="{{ route('frontend.property.index', ['for' => 'liked']) }}" class="btn btn-yellow"><i class="fa fa-plus"></i> {{ trans('property.my_properties.more_results') }}</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endif
        </div>
    </div>
    @endif
@endsection