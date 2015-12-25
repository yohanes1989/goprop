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
                        <li class="active"><a href="{{ route('frontend.property.map', ['id' => $model->id]) }}">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.map') }}</span>
                            </a></li>
                        <li class="current"><a href="">
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
                        <div class="form-wizard-bars" style="width: 60%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10">
            <header class="header-area">
                <h3 class="entry-title">{!! trans('property.photos.page_title', ['title' => $model->property_name]) !!}</h3>
            </header>
            <div class="row">
                <div class="col-xs-12">
                    <div class="entry-content">
                        {!! trans('property.photos.body_copy') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="register-form-wrapper">
                    <div class="col-xs-12">
                        <header class="header-area">
                            <h4 class="entry-title">{!! trans('property.photos.uploaded_photos_title') !!}</h4>
                        </header>
                        <div class="entry-content">
                            <div id="upload-tasks" class="row">
                                @if(count($model->photos) > 0)
                                    @foreach($model->photos as $photo)
                                        @include('frontend.property.upload_photo', ['model' => $model, 'photo' => $photo])
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <header class="header-area">
                            <h4 class="entry-title">{!! trans('property.photos.upload_photos_title') !!} <small>{!! trans('property.photos.upload_photos_hint') !!}</small></h4>
                        </header>
                        <div class="entry-content text-center">
                            <!-- The file upload form used as target for the file upload widget -->
                            {!! Form::model($model, ['id' => 'fileupload-form', 'files' => TRUE, 'route' => ['frontend.property.photos.upload', 'id' => $model->id, 'type' => 'photo']]) !!}
                            <div class="btn btn-yellow file-input-button btn-lg">
                                <span>{{ trans('property.photos.choose_photos') }}</span>
                                {!! Form::file('files[]', ['multiple' => true, 'id' => 'fileupload']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <hr class="form-divider" />
                    </div>

                    <div class="col-xs-12">
                        <header class="entry-header">
                            <h4 class="entry-title text-uppercase text-center">Presentation is the key</h4>
                            <p>&nbsp;</p>
                        </header>
                        <div class="entry-content">
                            <p>Great way to sell your property: all you nedd is few good photos, a good description and the right price. We use professional photographers because great photography is the crucial element in attracting potential buyers. We focus heavily on achieving the best possible photography to show your property off to its full potential.</p>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <strong>What we provide?</strong>
                    </div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <p>
                                    <strong>PHOTOGRAPHY</strong>
                                <ul>
                                    <li>Wide-Angle Photography</li>
                                    <li>Ultra wide angle photos</li>
                                    <li>SLR Camera for high quality</li>
                                </ul>
                                </p>
                                <p>&nbsp;</p>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <p>
                                    <strong>&nbsp;</strong>
                                <ul>
                                    <li>Make your property stand out</li>
                                    <li>Manage photos in your online account</li>
                                </ul>
                                </p>
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <p>
                                    <strong>FLOOR PLAN</strong>
                                <ul>
                                    <li>Layout guide of your property</li>
                                    <li>Floor SQ Meter included</li>
                                    <li>Proven to reduce wasted viewings</li>
                                </ul>
                                </p>
                                <p>&nbsp;</p>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <p>
                                    <strong>&nbsp;</strong>
                                <ul>
                                    <li>All floor included</li>
                                    <li>Floor SQ Meter included</li>
                                </ul>
                                </p>
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <p>
                                    <strong>VIRTUAL TOURS</strong>
                                <ul>
                                    <li>Moving image to showcase home</li>
                                    <li>Choose your rooms to be shown</li>
                                </ul>
                                </p>
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>

                    <div class="image-list">
                        <div class="col-sm-6 col-xs-12">
                            <div class="img-wrap">
                                <img src="{{ asset('assets/frontend/images/image-before-1.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="img-wrap">
                                <img src="{{ asset('assets/frontend/images/image-after-1.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="img-wrap">
                                <img src="{{ asset('assets/frontend/images/image-before-2.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="img-wrap">
                                <img src="{{ asset('assets/frontend/images/image-after-2.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="img-wrap">
                                <img src="{{ asset('assets/frontend/images/image-before-3.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="img-wrap">
                                <img src="{{ asset('assets/frontend/images/image-after-3.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>

                    {!! Form::model($model, ['route' => ['frontend.property.photos.process', 'id' => $model->id]]) !!}
                    <div class="col-xs-6">
                        <a href="{{ route('frontend.property.packages', ['id' => $model->id]) }}" class="btn btn-yellow">{{ trans('forms.skip_package_btn') }}</a>
                    </div>
                    <div class="col-xs-6 text-right">
                        {!! Form::button(trans('forms.save_continue_btn'), ['name' => 'action', 'value' => 'save_continue', 'type' => 'submit', 'class' => 'btn btn-yellow']) !!}
                    </div>
                    {!! Form::close() !!}

                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
@endsection

@section('styles')
    @parent

    <link rel="stylesheet" href="{{ asset('assets/frontend/vendor/jquery-file-upload/css/jquery.fileupload.css') }}">
@endsection

@section('bottom_scripts')
    @parent

    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="{{ asset('assets/frontend/vendor/jquery-file-upload/js/vendor/jquery.ui.widget.js') }}"></script>

    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="{{ asset('assets/frontend/vendor/jquery-file-upload/js/jquery.iframe-transport.js') }}"></script>
    <!-- The basic File Upload plugin -->
    <script src="{{ asset('assets/frontend/vendor/jquery-file-upload/js/jquery.fileupload.js') }}"></script>

    <script>
        /*jslint unparam: true */
        /*global window, $ */
        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = $('#fileupload-form').attr('action');

            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                sequentialUploads: true,
                add: function(e, data){
                    $('.upload-messages').remove();

                    $.each(data.files, function (index, file) {
                        if (file.type.match('image.*')) {
                            //$('#upload-tasks ul').append('<li>' + file.name + '</li>');
                        }else{
                            //data.files.splice(index,1);
                        }
                    });

                    data.submit();
                },
                done: function (e, data) {
                    for(var i=0; i<data.result.length; i+=1){
                        $('#upload-tasks').append(data.result[i]);
                    }
                },
                fail: function(e, data){
                    if($('.upload-messages').length < 1){
                        var $uploadMessages = $('<div class="upload-messages"></div>');
                        $uploadMessages.append('<ul></ul>');
                        $('#fileupload-form').before($uploadMessages);
                    }else{
                        var $uploadMessages = $('.upload-messages');
                    }

                    for(var i in data.jqXHR.responseJSON){
                        $uploadMessages.find('ul').append('<li>' + data.files[0].name + ': ' + data.jqXHR.responseJSON[i][0] + '</li>');
                    }
                }
            }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });

        function addPhotoDelete($button)
        {
            $button.click(function(e){

            });
        }
    </script>
@endsection