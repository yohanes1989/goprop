@extends('frontend.account.logged_in.layout')

@section('content')
    <div class="top-navigation">
        <div class="row">
            <div class="col-md-10">
                @include('frontend.property.includes.edit_top_bar')
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
                        <li class="active"><a href="{{ route('frontend.property.photos', ['id' => $model->id]) }}">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.photos') }}</span>
                            </a></li>
                        <li class="current"><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.floorplan') }}</span>
                            </a></li>
                        <li><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.packages') }}</span>
                            </a></li>
                    </ul>
                    <div class="form-wizard-progressbar">
                        <div class="form-wizard-bars" style="width: 72%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <header class="header-area">
                <h3 class="entry-title">{!! trans('property.floorplans.page_title', ['title' => $model->property_name]) !!}</h3>
            </header>
            <div class="row">
                <div class="col-xs-12">
                    <div class="entry-content">
                        <p>{!! trans('property.floorplans.body_copy') !!}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="register-form-wrapper">
                    <div class="col-xs-12">
                        <header class="header-area">
                            <h4 class="entry-title">{!! trans('property.floorplans.uploaded_floorplans_title') !!}</h4>
                        </header>
                        <div class="entry-content">
                            <div id="upload-tasks" class="row">
                                @if(count($model->floorplans) > 0)
                                    @foreach($model->floorplans as $floorplan)
                                        @include('frontend.property.upload_photo', ['model' => $model, 'photo' => $floorplan])
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <header class="header-area">
                            <h4 class="entry-title">{!! trans('property.floorplans.upload_photos_title') !!} <small>{!! trans('property.floorplans.upload_photos_hint') !!}</small></h4>
                        </header>
                        <div class="entry-content text-center">
                            <!-- The file upload form used as target for the file upload widget -->
                            {!! Form::model($model, ['id' => 'fileupload-form', 'files' => TRUE, 'route' => ['frontend.property.photos.upload', 'id' => $model->id, 'type' => 'floorplan']]) !!}
                            <div class="btn btn-yellow file-input-button btn-lg">
                                <span>{{ trans('property.floorplans.choose_floorplans') }}</span>
                                {!! Form::file('files[]', ['multiple' => true, 'id' => 'fileupload']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <hr class="form-divider" />
                    </div>

                    {!! Form::model($model, ['route' => ['frontend.property.floorplans.process', 'id' => $model->id]]) !!}
                    <div class="col-xs-12 text-right">
                        {!! Form::button(trans('forms.save_continue_btn'), ['name' => 'action', 'value' => 'save_continue', 'type' => 'submit', 'class' => 'btn btn-yellow']) !!}
                    </div>
                    {!! Form::close() !!}

                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
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

    <script src="{{ asset('assets/frontend/vendor/html5sortable/html.sortable.min.js') }}"></script>

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
                            data.context = $('<div class="col-xs-6 col-md-3"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style=""></div></div></div>');
                            data.context.appendTo('#upload-tasks');
                        }else{
                            //data.files.splice(index,1);
                        }
                    });

                    data.submit();
                },
                progress: function(e, data){
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    data.context.find('.progress-bar').prop('aria-valuenow', progress).css(
                            'width',
                            progress + '%'
                    );
                },
                done: function (e, data) {
                    for(var i=0; i<data.result.length; i+=1){
                        data.context.replaceWith(data.result[i]);
                        $('#upload-tasks').sortable('reload');
                    }
                },
                fail: function(e, data){
                    if($('.upload-messages').length < 1){
                        var $uploadMessages = $('<div class="upload-messages"><ul></ul></div>');
                        $('#fileupload-form').before($uploadMessages);
                    }

                    if(data.context){
                        data.context.remove();
                    }

                    for(var i in data.jqXHR.responseJSON){
                        $uploadMessages.find('ul').append('<li>' + data.files[0].name + ': ' + data.jqXHR.responseJSON[i][0] + '</li>');
                    }
                }
            }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');

            $('#upload-tasks').sortable().bind('sortstop', function(e, ui){
                var $photos = [];

                $('#upload-tasks .uploaded-item').each(function(idx, obj){
                    $photos.push($(obj).data('attachment_id'));
                });
                $.ajax(
                    '{{ route('frontend.property.photos.reorder', ['id' => $model->id, 'type' => 'floorplan']) }}',
                    {
                        data: {
                            'photos': $photos,
                            '_token': $('#fileupload-form input[name="_token"]').val()
                        },
                        method: 'post',
                        success: function(data){

                        },
                        error: function(xhr){
                            alert('Reorder error. Please try again.');
                        }
                    }
                );
            });
        });

        function addPhotoDelete($button)
        {
            $button.click(function(e){

            });
        }
    </script>
@endsection