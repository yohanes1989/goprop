<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('owner', 'Owner *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('owner', old('owner', isset($owner)?$owner:''), ['class' => 'form-control', 'id' => 'owner', 'data-autocomplete' => route('admin.member.find.auto_complete')]) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('status', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getStatusLabel(), null, ['class' => 'form-control', 'id' => 'status']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('address', 'Address *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::textarea('address', null, array('class'=>'form-control', 'id' => 'address', 'placeholder'=>'Address', 'rows' => 3)) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('location', 'Location *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('province', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getProvinces(true), null, ['class' => 'form-control form-address-selector-province', 'id' => 'province']) !!}
            <div style="height: 10px;"></div>
            {!! Form::select('city', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getCities(old('province', $property->province), true), null, ['class' => 'form-control form-address-selector-city', 'id' => 'city']) !!}
            <div style="height: 10px;"></div>
            {!! Form::select('subdistrict', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getSubdistricts(old('city', $property->city), true), null, ['class' => 'form-control form-address-selector-subdistrict', 'id' => 'subdistrict']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('postal_code', 'Postal Code *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('postal_code', null, array('id' => 'postal_code', 'class'=>'form-control','placeholder'=>'Postal Code')) !!}
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('property_name', 'Property Name *', array('class'=>'col-md-4 control-label')) !!}
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
        {!! Form::label('rooms', 'Rooms *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('rooms', null, array('class'=>'form-control', 'id' => 'rooms', 'placeholder'=>'Bedrooms')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('parking', 'Parking *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('parking', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getParkingOptionLabel(), null, ['class' => 'form-control', 'id' => 'parking']) !!}
        </div>
    </div>

    <div data-field-dependent="parking|garage" class="form-group">
        {!! Form::label('garage_size', 'Garage Size', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('garage_size', null, array('class'=>'form-control', 'id' => 'garage_size','placeholder'=>'Garage Size')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('bathrooms', 'Bathrooms *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('bathrooms', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getBathroomsLabel(), null, ['class' => 'form-control', 'id' => 'bathrooms']) !!}
        </div>
    </div>
</div>

<div class="col-md-4">
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
                    {!! Form::checkbox('rent_viewing_schedule[]', $viewingOptionIdx, (strpos($property->sell_viewing_schedule, $viewingOptionIdx) !== false)) !!} {{ $viewingOption }}
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
</div>

<div class="row">
    <div class="col-md-6">
        <h4 class="sub-header">Description</h4>

        <div class="form-group">
            {!! Form::label('land_size', 'Land Size', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-8">
                {!! Form::text('land_size', null, ['class' => 'form-control', 'id' => 'land_size']) !!}
            </div>
            <div class="col-md-1">m<sup>2</sup></div>
        </div>

        <div class="form-group">
            {!! Form::label('building_size', 'Building Size', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-8">
                {!! Form::text('building_size', null, ['class' => 'form-control', 'id' => 'building_size']) !!}
            </div>
            <div class="col-md-1">m<sup>2</sup></div>
        </div>

        <div class="form-group">
            {!! Form::label('floors', 'Floors', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-9">
                {!! Form::select('floors', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getFloorsLabel(), null, ['class' => 'form-control', 'id' => 'floors']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('certificate', 'Certificate', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-9">
                {!! Form::select('certificate', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getCertificateLabel(), null, ['class' => 'form-control', 'id' => 'certificate']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Short Description *', ['class' => 'control-label col-md-3']) !!}
            <div class="col-md-9">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5, 'id' => 'description']) !!}
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

<div class="row">
    <h4 class="sub-header">Package</h4>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::select('package', ['' => 'Select Package'] + $packageOptions, [$property->packages->first()->id], ['class' => 'form-control', 'id' => 'package-select']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div id="addons-wrapper">
            @if($property->packages)
                @foreach($property->packages->first()->paidFeatures as $feature)
                    <div class="checkbox">
                        <label>{!! Form::checkbox('features[]', $feature->id, in_array($feature->id, $property->getPackageAddons())) !!} {{ $feature->name }}</label>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
        {!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}

        <a href="{{ route('admin.property.index') }}" class="btn btn-warning">Cancel</a>
    </div>
</div>

@section('bottom_scripts')
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="{{ asset('assets/frontend/vendor/gmaps/gmaps.min.js') }}"></script>

    @parent

    <script>
        $(document).ready(function() {
            $('#package-select').on('change', function(){
                $.ajax(
                        global_vars.admin_path+'/packages/'+$(this).val()+'/features/0',
                        {
                            method: 'get',
                            success: function(data){
                                $('#addons-wrapper').empty();

                                for(var i in data){
                                    var $checkbox = [
                                        '<div class="checkbox"><label>',
                                        '<input type="checkbox" value="'+i+'" name="features[]" /> '+data[i].name,
                                        '</label></div>'
                                    ];
                                    $('#addons-wrapper').append($checkbox.join(''));
                                }
                            }
                        }
                );
            });

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
    </script>
@endsection