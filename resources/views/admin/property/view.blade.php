@extends('admin.layouts.master')

@section('title', $property->property_name.' ('.$property->listing_code.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.property.index') }}"><i class="gi gi-home"></i> Properties</a></li>
    <li>{{ $property->property_name.' ('.$property->listing_code.')' }}</li>
@endsection

@section('content')
    <?php
    $isAdmin = \Illuminate\Support\Facades\Auth::user()->is('administrator');
    ?>

    <div class="block">
        <div class="block-title">
            <h4>{{ $property->property_name.' ('.$property->listing_code.')' }}</h4>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('listing_code', 'Listing Code', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ $property->listing_code }}
                </div>
                <div class="clearfix"></div>
            </div>

            @if(Auth::user()->is('administrator'))
                <div class="form-group">
                    {!! Form::label('owner', 'Owner', array('class'=>'col-md-4 control-label')) !!}
                    <div class="col-md-8">
                        {{ $owner }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('listing_agent', 'Listing Agent', array('class'=>'col-md-4 control-label')) !!}
                    <div class="col-md-8">
                        {{ $property->agentList?$property->agentList->profile->singleName:'Unassigned' }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('listing_referral', 'Listing Referral', array('class'=>'col-md-4 control-label')) !!}
                    <div class="col-md-8">
                        {{ $property->referralList?$property->referralList->profile->singleName:'Unassigned' }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('selling_agent', 'Selling Agent', array('class'=>'col-md-4 control-label')) !!}
                    <div class="col-md-8">
                        {{ $property->agentSell?$property->agentSell->profile->singleName:'Unassigned' }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('selling_referral', 'Selling Referral', array('class'=>'col-md-4 control-label')) !!}
                    <div class="col-md-8">
                        {{ $property->referralSell?$property->referralSell->profile->singleName:'Unassigned' }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('status', 'Status', array('class'=>'col-md-4 control-label')) !!}
                    <div class="col-md-8">
                        {{ $property->status?\GoProp\Models\Property::getStatusLabel($property->status):'' }}
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endif

            <div class="form-group">
                {!! Form::label('address', 'Address', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {!! nl2br($property->address) !!}
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                {!! Form::label('location', 'Location', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ $property->province?\GoProp\Facades\AddressHelper::getAddressLabel($property->province, 'province'):'' }}<br/>
                    {{ $property->city?\GoProp\Facades\AddressHelper::getAddressLabel($property->city, 'city'):'' }}<br/>
                    {{ $property->subdistrict?\GoProp\Facades\AddressHelper::getAddressLabel($property->subdistrict, 'subdistrict'):'' }}
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                {!! Form::label('postal_code', 'Postal Code', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ $property->postal_code }}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('property_name', 'Listing Title', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ $property->property_name }}
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                {!! Form::label('property_type', 'Property Type', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ $property->type?$property->type->name:'' }}
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                {!! Form::label('bedrooms', 'Bedrooms', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ trans_choice('forms.fields.property.room_count', $property->rooms) }}
                </div>
                <div class="clearfix"></div>

            </div>

            <div class="form-group">
                {!! Form::label('bathrooms', 'Bathrooms', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ trans_choice('forms.fields.property.bathroom_count', $property->bathrooms) }}
                </div>
                <div class="clearfix"></div>

            </div>

            <div class="form-group">
                {!! Form::label('maid_rooms', 'Maid Bedrooms', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ trans_choice('forms.fields.property.maid_bedroom_count', $property->maid_rooms) }}
                </div>
                <div class="clearfix"></div>

            </div>
            <div class="form-group">
                {!! Form::label('maid_bathrooms', 'Maid Bathrooms', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ trans_choice('forms.fields.property.maid_bathroom_count', $property->maid_bathrooms) }}
                </div>
                <div class="clearfix"></div>

            </div>

            <div class="form-group">
                {!! Form::label('furnishing', 'Furnishing', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ $property->furnishing?\GoProp\Models\Property::getFurnishingLabel($property->furnishing):'' }}
                </div>
                <div class="clearfix"></div>

            </div>

            <div class="form-group">
                {!! Form::label('carport_size', 'Carport Size', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ trans_choice('forms.fields.property.car_count', $property->carport_size) }}
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                {!! Form::label('garage_size', 'Garage Size', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{ trans_choice('forms.fields.property.car_count', $property->garage_size) }}
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                {!! Form::label('short_note', 'Short Note', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {!! nl2br($property->short_note) !!}
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                {!! Form::label('personal_note', 'Personal Note', array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {!! nl2br($property->personal_note) !!}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-6">
                <h4 class="sub-header">Description</h4>

                <div class="form-group">
                    {!! Form::label('description', 'Listing Description', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {!! nl2br($property->description) !!}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('land_size', 'Land Size', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-8">
                        {!! intval($property->land_size)?$property->land_size.' m<sup>2</sup>':'' !!}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('land_dimension', 'Land Dimension', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-2">
                        {{ $property->land_dimension['length']?$property->land_dimension['length']:'-' }}
                    </div>
                    <div class="col-md-1 text-center">
                        x
                    </div>
                    <div class="col-md-2">
                        {{ $property->land_dimension['width']?$property->land_dimension['width']:'-' }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('building_size', 'Building Size', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-8">
                        {!! intval($property->building_size)?$property->building_size.' m<sup>2</sup>':'' !!}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('building_dimension', 'Building Dimension', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-2">
                        {{ $property->building_dimension['length']?$property->building_dimension['length']:'-' }}
                    </div>
                    <div class="col-md-1 text-center">
                        x
                    </div>
                    <div class="col-md-2">
                        {{ $property->building_dimension['width']?$property->building_dimension['width']:'-' }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('floors', 'Floors', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {{ $property->floors?$property->floors+0:'' }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('phone_lines', 'Phone Lines', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {{ trans_choice('forms.fields.property.phone_line_count', $property->phone_lines) }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('electricity', 'Electricity', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {{ $property->electricity?\GoProp\Models\Property::getElectricityLabel($property->electricity):'' }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('orientation', 'Orientation', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {{ $property->orientation?\GoProp\Models\Property::getOrientationLabel($property->orientation):'' }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('certificate', 'Certificate', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {{ $property->certificate?\GoProp\Models\Property::getCertificateLabel($property->certificate):'' }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('virtual_tour_url', 'Virtual Reality URL', ['class' => 'control-label col-md-3']) !!}
                    <div class="col-md-9">
                        {{ $property->virtual_tour_url }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                @if($property->photos->count() > 0)
                <h4 class="sub-header">Photos</h4>

                <div class="row gallery" data-toggle="lightbox-gallery">
                    @foreach($property->photos as $photo)
                        <div class="col-md-2 col-sm-4">
                            <a href="{{ url('images/photo_gallery/'.$photo->filename) }}" class="gallery-link" target="_blank"><img class="img-responsive" src="{{ url('images/photo_thumbnail/'.$photo->filename) }}" /></a>
                        </div>
                    @endforeach
                </div>
                @endif

                    @if($property->floorplans->count() > 0)
                        <h4 class="sub-header">Floorplan</h4>

                        <div class="row gallery" data-toggle="lightbox-gallery">
                            @foreach($property->floorplans as $photo)
                                <div class="col-md-2 col-sm-4">
                                    <a href="{{ url('images/photo_gallery/'.$photo->filename) }}" class="gallery-link" target="_blank"><img class="img-responsive" src="{{ url('images/photo_thumbnail/'.$photo->filename) }}" /></a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                <h4 class="sub-header">Maps</h4>

                <div class="form-group">
                    <div id="google-map-wrapper">
                        <div class="gmaps-form-area">
                            <div class="popin">
                                <div id="map" style="height: 400px;"></div>
                            </div>
                        </div>
                        {!! Form::hidden('latitude', null, ['id' => 'latitude']) !!}
                        {!! Form::hidden('longitude', null, ['id' => 'longitude']) !!}
                    </div>
                </div>
            </div>
        </div>

        <h4 class="sub-header">Packages</h4>

        <div class="row gutter30">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('for_sell', 'Is this property for Sell?', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::select('for_sell', ['' => trans('forms.please_select')] + \GoProp\Facades\ProjectHelper::getYesNoOptions(), [$property->for_sell], ['disabled' => true, 'class' => 'form-control', 'id' => 'for_sell']) !!}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div data-field-dependent="for_sell|1" class="form-group">
                    {!! Form::label('sell_viewing_schedule', 'Viewing Schedule', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        @foreach(\GoProp\Models\Property::getViewingScheduleOptionLabel() as $viewingOptionIdx => $viewingOption)
                            <label class="checkbox-inline">
                                {!! Form::checkbox('sell_viewing_schedule[]', $viewingOptionIdx, (strpos($property->sell_viewing_schedule, $viewingOptionIdx) !== false), ['disabled' => true, ]) !!} {{ $viewingOption }}
                            </label>
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div data-field-dependent="for_sell|1" class="form-group">
                    {!! Form::label('sell_price', 'Sell Price', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {{ $property->sell_price }}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div data-field-dependent="for_sell|1" class="form-group">
                    <h5><strong>{{ $sellPackage?$sellPackage->name:'' }}</strong></h5>

                    <div class="addons-wrapper">
                        @if($sellPackage)
                            @foreach($sellPackage->paidFeatures as $idx=>$feature)
                                <div class="checkbox">
                                    <label>{!! Form::checkbox('features[sell]['.$idx.']', $feature->id, old('features.sell.'.$idx, in_array($feature->id, $property->getPackageAddons($sellPackage))), ['disabled' => true, ]) !!} {{ $feature->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('for_rent', 'Is this property for Rent?', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {!! Form::select('for_rent', ['' => trans('forms.please_select')] + \GoProp\Facades\ProjectHelper::getYesNoOptions(), [$property->for_rent], ['disabled' => true, 'class' => 'form-control', 'id' => 'for_rent']) !!}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div data-field-dependent="for_rent|1" class="form-group">
                    {!! Form::label('rent_viewing_schedule', 'Viewing Schedule *', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        @foreach(\GoProp\Models\Property::getViewingScheduleOptionLabel() as $viewingOptionIdx => $viewingOption)
                            <label class="checkbox-inline">
                                {!! Form::checkbox('rent_viewing_schedule[]', $viewingOptionIdx, (strpos($property->rent_viewing_schedule, $viewingOptionIdx) !== false), ['disabled' => true, ]) !!} {{ $viewingOption }}
                            </label>
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div data-field-dependent="for_rent|1" class="form-group">
                    {!! Form::label('rent_price', 'Rent Price *', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-8">
                        {{ $property->rent_price }}<br/>
                        {!! Form::select('rent_price_type', \GoProp\Models\Property::getRentTypeLabel(), null, ['disabled' => true, 'class' => 'form-control', 'id' => 'rent_price_type']) !!}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div data-field-dependent="for_rent|1" class="form-group">
                    <h5><strong>{{ $rentPackage?$rentPackage->name:'' }}</strong></h5>

                    <div class="addons-wrapper">
                        @if($rentPackage)
                            @foreach($rentPackage->paidFeatures as $idx=>$feature)
                                <div class="checkbox">
                                    <label>{!! Form::checkbox('features[rent]['.$idx.']', $feature->id, old('features.rent.'.$idx, in_array($feature->id, $property->getPackageAddons($rentPackage))), ['disabled' => true, ]) !!} {{ $feature->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($isAdmin)
        <h4 class="sub-header">Property Portals</h4>

        <div class="row">
            <?php $allPortals = \GoProp\Models\PropertyPortal::getAllPortals(); ?>
            @foreach($allPortals as $portal)
                <div class="col-md-2">
                    <label><i class="fa fa-{!! in_array($portal->id, $property->propertyPortals->pluck('id')->all())?'check':'times' !!}"></i> {{ $portal->name }}</label>
                </div>
            @endforeach
        </div>
        @endif
    </div>

    <div class="form-group">
        <a href="{{ Request::get('backUrl', route('admin.property.index')) }}" class="btn btn-warning">Back</a>
    </div>
@endsection

@section('bottom_scripts')
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="{{ asset('assets/frontend/vendor/gmaps/gmaps.min.js') }}"></script>

    @parent

    <script>
        $(document).ready(function() {
            openMap();
        });

        function openMap()
        {
            // Javascript for Google Maps with Search Field
            map = new GMaps({
                div: '#map',
                lat: {{ $defaultLatitude }},
                lng: {{ $defaultLongitude }},
                zoom: 17,
                dragend: function(e) {
                    $('#latitude').val(this.getCenter().lat());
                    $('#longitude').val(this.getCenter().lng());
                }
            });
        }
    </script>
@endsection