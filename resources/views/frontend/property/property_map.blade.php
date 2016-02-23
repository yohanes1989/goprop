@extends('frontend.account.logged_in.layout')

@section('content')
    <div class="top-navigation">
        <div class="row">
            <div class="col-sm-10">
                <div class="menu-preview">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('frontend.property.view', ['for' => $model->getViewFor(), 'id' => $model->id, 'preview' => TRUE, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}"><img src="{{ asset('assets/frontend/images/property-preview.png') }}" alt="" /> {{ trans('property.create.preview_property') }}</a></li>
                        <li><a href="#"><img src="{{ asset('assets/frontend/images/property-disable.png') }}" alt="" /> Disable property</a></li>
                    </ul>
                </div>
                <div class="form-wizard-menu">
                    <ul class="list-unstyled">
                        <li class="active"><a href="{{ route('frontend.property.edit', ['id' => $model->id]) }}">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.main_details') }}</span>
                            </a></li>
                        <li class="active"><a href="{{ route('frontend.property.details', ['id' => $model->id]) }}">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.property_details') }}</span>
                            </a></li>
                        <li class="current"><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.map') }}</span>
                            </a></li>
                        <li><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.photos') }}</span>
                            </a></li>
                        <li><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.floorplan') }}</span>
                            </a></li>
                        <li><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.packages') }}</span>
                            </a></li>
                    </ul>
                    <div class="form-wizard-progressbar">
                        <div class="form-wizard-bars" style="width: 44%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10">
            <header class="header-area">
                <h3 class="entry-title">{!! trans('property.map.page_title', ['title' => $model->property_name]) !!}</h3>
            </header>
            <label>{!! Form::checkbox('point_map', 1, old('point_map', ($model->latitude && $model->longitude)), ['id' => 'point-map-checkbox']) !!} {{ trans('property.map.point_map_question') }}</label>
            <div id="google-map-wrapper">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="entry-content">
                            <p>{{ trans('property.map.body_copy') }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="register-form-wrapper">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="gmaps-form-area">
                                    <div class="gmaps-form-search">
                                        <form id="geocoding_form">
                                            <div class="input">
                                                <input type="text" id="address" name="address" class="form-control" placeholder="{{ trans('property.map.search_map') }}" />
                                            </div>
                                        </form>
                                    </div>
                                    <div class="popin">
                                        <div class="maps-container"><div id="map" style="height: 400px;"></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/><br/>
            <div class="row">
                {!! Form::model($model, ['route' => ['frontend.property.map.process', 'id' => $model->id]]) !!}
                {!! Form::hidden('latitude', null, ['id' => 'latitude']) !!}
                {!! Form::hidden('longitude', null, ['id' => 'longitude']) !!}
                {!! Form::hidden('point_map', 0, ['id' => 'point-map-hidden']) !!}

                <div class="col-xs-4">
                    <a href="{{ route('frontend.property.packages', ['id' => $model->id]) }}" class="btn btn-yellow">{{ trans('forms.skip_package_btn') }}</a>
                </div>
                <div class="col-xs-4 text-center">
                    {!! Form::button(trans('forms.save_information_btn'), ['name' => 'action', 'value' => 'save_information', 'type' => 'submit', 'class' => 'btn btn-yellow']) !!}
                </div>
                <div class="col-xs-4 text-right">
                    {!! Form::button(trans('forms.save_continue_btn'), ['name' => 'action', 'value' => 'save_continue', 'type' => 'submit', 'class' => 'btn btn-yellow']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
@endsection

@section('bottom_scripts')
    <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="{{ asset('assets/frontend/vendor/gmaps/gmaps.min.js') }}"></script>

    @parent

    <script>
        $(document).ready(function() {
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

             $('#geocoding_form').submit(function(ex){
                 ex.preventDefault();

                 GMaps.geocode({
                     address: $('#address').val().trim(),
                     callback: function(results, status){
                         if(status=='OK'){
                             var latlng = results[0].geometry.location;
                             map.setCenter(latlng.lat(), latlng.lng());

                             $('#latitude').val(latlng.lat());
                             $('#longitude').val(latlng.lng());
                         }
                     }
                 });
             });
        });

        function openMap()
        {
            $('#google-map-wrapper').show();
            $('#point-map-hidden').val(1);

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

            @if($mapDefault)
            /*
             GMaps.geolocate({
             success: function(position) {
             map.setCenter(position.coords.latitude, position.coords.longitude);
             $('#latitude').val(position.coords.latitude);
             $('#longitude').val(position.coords.longitude);
             },
             error: function(error) {
             alert('Geolocation failed: '+error.message);
             },
             not_supported: function() {
             alert("Your browser does not support geolocation");
             }
             });
             */

            GMaps.geocode({
                address: '{{ $mapSearch }}',
                callback: function(results, status){
                    if(status=='OK'){
                        var latlng = results[0].geometry.location;
                        map.setCenter(latlng.lat(), latlng.lng());

                        $('#latitude').val(latlng.lat());
                        $('#longitude').val(latlng.lng());
                    }
                }
            });
            @endif
        }
    </script>
@endsection