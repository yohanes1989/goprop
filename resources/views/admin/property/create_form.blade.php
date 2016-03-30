<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('listing_code', 'Listing Code', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            <h5><strong>{{ $property->listing_code }}</strong></h5>
        </div>
    </div>

    @if(Auth::user()->is('administrator'))
    <div class="form-group">
        {!! Form::label('owner', 'Owner *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('owner', old('owner', isset($owner)?$owner:''), ['class' => 'form-control', 'id' => 'owner', 'data-autocomplete' => route('admin.member.find.auto_complete', ['roles' => ['agent', 'authenticated_user']])]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('listing_referral', 'Listing Referral', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('listing_referral', old('listing_referral', $property->referralList?$property->referralList->email:''), ['class' => 'form-control', 'id' => 'listing_referral', 'data-autocomplete' => route('admin.member.find.auto_complete', ['roles' => ['agent']])]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('selling_agent', 'Selling Agent', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('selling_agent', old('selling_agent', $property->agentSell?$property->agentSell->email:''), ['class' => 'form-control', 'id' => 'selling_agent', 'data-autocomplete' => route('admin.member.find.auto_complete', ['roles' => ['agent']])]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('selling_referral', 'Selling Referral', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('selling_referral', old('selling_referral', $property->referralSell?$property->referralSell->email:''), ['class' => 'form-control', 'id' => 'selling_referral', 'data-autocomplete' => route('admin.member.find.auto_complete', ['roles' => ['agent']])]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('status', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getStatusLabel(), null, ['class' => 'form-control', 'id' => 'status']) !!}
        </div>
    </div>
    @endif

    <div class="form-group">
        {!! Form::label('address', 'Address *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::textarea('address', null, array('class'=>'form-control', 'id' => 'address', 'placeholder'=>'Address', 'rows' => 3)) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('location', 'Location *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('province', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getProvinces(true), null, ['class' => 'form-control form-address-selector-province select-chosen', 'id' => 'province']) !!}
            <div style="height: 10px;"></div>
            {!! Form::select('city', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getCities(old('province', $property->province), true), null, ['class' => 'form-control form-address-selector-city select-chosen', 'id' => 'city']) !!}
            <div style="height: 10px;"></div>
            {!! Form::select('subdistrict', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getSubdistricts(old('city', $property->city), true), null, ['class' => 'form-control form-address-selector-subdistrict select-chosen', 'id' => 'subdistrict']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('postal_code', 'Postal Code', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('postal_code', null, array('id' => 'postal_code', 'class'=>'form-control','placeholder'=>'Postal Code')) !!}
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('property_name', 'Listing Title *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('property_name', null, array('class'=>'form-control', 'id' => 'property_name', 'placeholder'=>'Property Name')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('property_type', 'Property Type *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('property_type_id', ['' => trans('forms.please_select')] + \GoProp\Models\PropertyType::getOptions(), null, ['class' => 'form-control', 'id' => 'property_type']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('bedrooms', 'Bedrooms *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('rooms', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getBedroomsLabel(), null, ['class' => 'form-control', 'id' => 'bedrooms']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('bathrooms', 'Bathrooms *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('bathrooms', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getBathroomsLabel(), null, ['class' => 'form-control', 'id' => 'bathrooms']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('maid_rooms', 'Maid Bedrooms', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('maid_rooms', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getMaidBedroomsLabel(), null, ['class' => 'form-control', 'id' => 'maid_rooms']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('maid_bathrooms', 'Maid Bathrooms', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('maid_bathrooms', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getMaidBathroomsLabel(), null, ['class' => 'form-control', 'id' => 'maid_bathrooms']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('furnishing', 'Furnishing *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('furnishing', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getFurnishingLabel(), null, ['class' => 'form-control', 'id' => 'furnishing']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('carport_size', 'Carport Size', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('carport_size', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getCarsLabel(), null, ['class' => 'form-control', 'id' => 'garage_size']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('garage_size', 'Garage Size', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('garage_size', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getCarsLabel(), null, ['class' => 'form-control', 'id' => 'garage_size']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('short_note', 'Short Note', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::textarea('short_note', null, ['class' => 'form-control', 'rows' => 3, 'id' => 'short_note']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('personal_note', 'Personal Note', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::textarea('personal_note', null, ['class' => 'form-control', 'rows' => 3, 'id' => 'personal_note']) !!}
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-6">
        <h4 class="sub-header">Description</h4>

        <div class="form-group">
            {!! Form::label('description', 'Listing Description', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-9">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5, 'id' => 'description']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('land_size', 'Land Size', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-8">
                {!! Form::text('land_size', old('land_size', intval($property->land_size)?$property->land_size:''), ['class' => 'form-control', 'id' => 'land_size']) !!}
            </div>
            <div class="col-md-1">m<sup>2</sup></div>
        </div>

        <div class="form-group">
            {!! Form::label('land_dimension', 'Land Dimension', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-2">
                {!! Form::text('land_dimension[length]', null, ['class' => 'form-control', 'placeholder' => 'Length', 'id' => 'land_dimension_length']) !!}
            </div>
            <div class="col-md-1 text-center">
                x
            </div>
            <div class="col-md-2">
                {!! Form::text('land_dimension[width]', null, ['class' => 'form-control', 'placeholder' => 'Width', 'id' => 'land_dimension_width']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('building_size', 'Building Size', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-8">
                {!! Form::text('building_size', old('building_size', intval($property->building_size)?$property->building_size:''), ['class' => 'form-control', 'id' => 'building_size']) !!}
            </div>
            <div class="col-md-1">m<sup>2</sup></div>
        </div>

        <div class="form-group">
            {!! Form::label('building_dimension', 'Building Dimension', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-2">
                {!! Form::text('building_dimension[length]', null, ['class' => 'form-control', 'placeholder' => 'Length', 'id' => 'building_dimension_length']) !!}
            </div>
            <div class="col-md-1 text-center">
                x
            </div>
            <div class="col-md-2">
                {!! Form::text('building_dimension[width]', null, ['class' => 'form-control', 'placeholder' => 'Width', 'id' => 'building_dimension_width']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('floors', 'Floors', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-9">
                {!! Form::select('floors', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getFloorsLabel(), null, ['class' => 'form-control', 'id' => 'floors']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('phone_lines', 'Phone Lines', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-9">
                {!! Form::select('phone_lines', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getPhoneLinesLabel(), null, ['class' => 'form-control', 'id' => 'phone_lines']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('electricity', 'Electricity', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-9">
                {!! Form::select('electricity', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getElectricityLabel(), null, ['class' => 'form-control', 'id' => 'electricity']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('orientation', 'Orientation', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-9">
                {!! Form::select('orientation', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getOrientationLabel(), null, ['class' => 'form-control', 'id' => 'orientation']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('certificate', 'Certificate', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-9">
                {!! Form::select('certificate', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getCertificateLabel(), null, ['class' => 'form-control', 'id' => 'certificate']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('virtual_tour_url', 'Virtual Reality URL', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-9">
                {!! Form::text('virtual_tour_url', null, ['class' => 'form-control', 'id' => 'virtual_tour_url']) !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <h4 class="sub-header">Maps</h4>

        <div class="form-group">
            <label>{!! Form::checkbox('point_map', 1, old('point_map', ($property->latitude && $property->longitude)), ['id' => 'point-map-checkbox']) !!} Pin location on Google Map</label>

            <div id="google-map-wrapper">
            <div class="gmaps-form-area">
                <div class="gmaps-form-search">
                    <input type="text" id="map_address" name="map_address" class="form-control" placeholder="{{ trans('property.map.search_map') }}" />
                </div>
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
            {!! Form::label('for_sell', 'Is this property for Sell? *', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::select('for_sell', ['' => trans('forms.please_select')] + \GoProp\Facades\ProjectHelper::getYesNoOptions(), null, ['class' => 'form-control', 'id' => 'for_sell']) !!}
            </div>
        </div>

        <div data-field-dependent="for_sell|1" class="form-group">
            {!! Form::label('sell_viewing_schedule', 'Viewing Schedule *', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                @foreach(\GoProp\Models\Property::getViewingScheduleOptionLabel() as $viewingOptionIdx => $viewingOption)
                    <label class="checkbox-inline">
                        {!! Form::checkbox('sell_viewing_schedule[]', $viewingOptionIdx, (strpos($property->sell_viewing_schedule, $viewingOptionIdx) !== false)) !!} {{ $viewingOption }}
                    </label>
                @endforeach
            </div>
        </div>

        <div data-field-dependent="for_sell|1" class="form-group">
            {!! Form::label('sell_price', 'Sell Price *', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('sell_price', null, ['class' => 'form-control', 'id' => 'sell_price']) !!}
            </div>
        </div>

        <div data-field-dependent="for_sell|1" class="form-group">
            {!! Form::select('sell_package', ['' => 'Select Package'] + $sellPackageOptions, $sellPackage?[$sellPackage->id]:null, ['class' => 'form-control package-select']) !!}

            <div class="addons-wrapper">
                @if($sellPackage)
                    @foreach($sellPackage->paidFeatures as $idx=>$feature)
                        <div class="checkbox">
                            <label>{!! Form::checkbox('features[sell]['.$idx.']', $feature->id, old('features.sell.'.$idx, in_array($feature->id, $property->getPackageAddons($sellPackage)))) !!} {{ $feature->name }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('for_rent', 'Is this property for Rent? *', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::select('for_rent', ['' => trans('forms.please_select')] + \GoProp\Facades\ProjectHelper::getYesNoOptions(), null, ['class' => 'form-control', 'id' => 'for_rent']) !!}
            </div>
        </div>

        <div data-field-dependent="for_rent|1" class="form-group">
            {!! Form::label('rent_viewing_schedule', 'Viewing Schedule *', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                @foreach(\GoProp\Models\Property::getViewingScheduleOptionLabel() as $viewingOptionIdx => $viewingOption)
                    <label class="checkbox-inline">
                        {!! Form::checkbox('rent_viewing_schedule[]', $viewingOptionIdx, (strpos($property->rent_viewing_schedule, $viewingOptionIdx) !== false)) !!} {{ $viewingOption }}
                    </label>
                @endforeach
            </div>
        </div>

        <div data-field-dependent="for_rent|1" class="form-group">
            {!! Form::label('rent_price', 'Rent Price *', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('rent_price', null, ['class' => 'form-control', 'id' => 'rent_price']) !!}
                {!! Form::select('rent_price_type', \GoProp\Models\Property::getRentTypeLabel(), null, ['class' => 'form-control', 'id' => 'rent_price_type']) !!}
            </div>
        </div>

        <div data-field-dependent="for_rent|1" class="form-group">
            {!! Form::select('rent_package', ['' => 'Select Package'] + $rentPackageOptions, $rentPackage?[$rentPackage->id]:null, ['class' => 'form-control package-select']) !!}

            <div class="addons-wrapper">
                @if($rentPackage)
                    @foreach($rentPackage->paidFeatures as $idx=>$feature)
                        <div class="checkbox">
                            <label>{!! Form::checkbox('features[rent]['.$idx.']', $feature->id, old('features.rent.'.$idx, in_array($feature->id, $property->getPackageAddons($rentPackage)))) !!} {{ $feature->name }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        {!! Form::hidden('backUrl', Request::get('backUrl', route('admin.property.index'))) !!}
        {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
        {!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}

        <a href="{{ Request::get('backUrl', route('admin.property.index')) }}" class="btn btn-warning">Cancel</a>
    </div>
</div>

@section('bottom_scripts')
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="{{ asset('assets/frontend/vendor/gmaps/gmaps.min.js') }}"></script>

    @parent

    <script>
        $(document).ready(function() {
            $('.package-select').on('change', function(){
                var $select = $(this);
                $.ajax(
                        global_vars.admin_path+'/packages/'+$select.val()+'/features/0',
                        {
                            method: 'get',
                            success: function(data){
                                $select.parent().find('.addons-wrapper').empty();

                                var count = 0;

                                for(var i in data){
                                    var $checkbox = [
                                        '<div class="checkbox"><label>',
                                        '<input type="checkbox" value="'+i+'" name="features['+data[i].category+']['+count+']" /> '+data[i].name,
                                        '</label></div>'
                                    ];
                                    $select.parent().find('.addons-wrapper').append($checkbox.join(''));
                                    count += 1;
                                }
                            }
                        }
                );
            });

            $('#google-map-wrapper').hide();

            if($('#point-map-checkbox').is(':checked')){
                openMap();
            }

            $('#point-map-checkbox').on('click', function(){
                if($(this).is(':checked')){
                    openMap();
                }else{
                    $('#google-map-wrapper').hide();
                    $('#point-map-hidden').val(0);
                }
            });

             $('#map_address').keypress(function(e){
                if(e.which == 13){
                    e.preventDefault();

                    GMaps.geocode({
                        address: $('#map_address').val().trim(),
                        callback: function(results, status){
                            if(status=='OK'){
                                var latlng = results[0].geometry.location;
                                map.setCenter(latlng.lat(), latlng.lng());

                                $('#latitude').val(latlng.lat());
                                $('#longitude').val(latlng.lng());
                            }
                        }
                    });
                }
            });
        });

        function openMap()
        {
            $('#google-map-wrapper').show();

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