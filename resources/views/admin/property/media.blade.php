
@extends('admin.layouts.master')

@section('title', 'Property Media ('.$property->property_name.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.property.index') }}"><i class="gi gi-home"></i> Properties</a></li>
    <li>Property Media ({{ $property->property_name }})</li>
@endsection

@section('content')
    <div class="form-group">
        <a href="{{ \Illuminate\Support\Facades\Request::get('backUrl', route('admin.property.index')) }}" class="btn btn-info">Back</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="block">
                <div class="block-title">
                    <h4>Photos for {{ $property->property_name }}</h4>

                    <div class="block-options pull-right">
                        <div class="btn-group btn-group-sm">
                            {!! Form::open(['route' => ['admin.property.media.delete_all', 'id' => $property->id, 'type' => 'photo'], 'style' => 'display: inline;']) !!}
                            <button class="btn btn-xs btn-default btn-confirm" data-toggle="tooltip" title="" data-original-title="Delete All">Delete all</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="upload-form-wrapper">
                    <div class="uploaded row">
                        @foreach($property->photos as $photo)
                            @include('admin.property.upload_photo', ['property' => $property, 'photo' => $photo])
                        @endforeach
                    </div>
                    {!! Form::model($property, array('route' => ['admin.property.media.upload', 'id' => $property->id, 'type' => 'photo'], 'class' => 'upload-form form-horizontal', 'data-type' => 'photo', 'files'=>true)) !!}
                    <div class="form-group">
                        {!! Form::file('files[]', ['class' => 'form-file', 'multiple' => true]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="form-group">
                <div class="btn-group">
                    @if($property->photos->count() > 0)
                    <a href="{{ route('admin.property.media.download', ['id' => $property->id, 'type' => 'photo']) }}" class="btn btn-xs btn-info">Download</a>
                    @endif
                    @if($property->downloadFolderExists('photo'))
                    <a href="{{ route('admin.property.media.download.clear', ['id' => $property->id, 'type' => 'photo']) }}" class="btn btn-xs btn-default">Clear Download</a>
                    @endif
                </div>

                @if($property->downloadFolderExists('photo'))
                <div class="help-block"><strong>Clear Download</strong> after the download has finished so it won't consume website storage.</div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="block">
                <div class="block-title">
                    <h4>Floorplans for {{ $property->property_name }}</h4>

                    <div class="block-options pull-right">
                        <div class="btn-group btn-group-sm">
                            {!! Form::open(['route' => ['admin.property.media.delete_all', 'id' => $property->id, 'type' => 'floorplan'], 'style' => 'display: inline;']) !!}
                            <button class="btn btn-xs btn-default btn-confirm" data-toggle="tooltip" title="" data-original-title="Delete All">Delete all</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="upload-form-wrapper">
                    <div class="uploaded row">
                        @foreach($property->floorplans as $photo)
                            @include('admin.property.upload_photo', ['property' => $property, 'photo' => $photo])
                        @endforeach
                    </div>
                    {!! Form::model($property, array('route' => ['admin.property.media.upload', 'id' => $property->id, 'type' => 'floorplan'], 'class' => 'upload-form form-horizontal', 'data-type' => 'floorplan', 'files'=>true)) !!}
                    <div class="form-group">
                        {!! Form::file('files[]', ['class' => 'form-file', 'multiple' => true]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="form-group">
                <div class="btn-group">
                    @if($property->floorplans->count() > 0)
                        <a href="{{ route('admin.property.media.download', ['id' => $property->id, 'type' => 'floorplan']) }}" class="btn btn-xs btn-info">Download</a>
                    @endif
                    @if($property->downloadFolderExists('floorplan'))
                        <a href="{{ route('admin.property.media.download.clear', ['id' => $property->id, 'type' => 'floorplan']) }}" class="btn btn-xs btn-default">Clear Download</a>
                    @endif
                </div>

                @if($property->downloadFolderExists('floorplan'))
                <div class="help-block"><strong>Clear Download</strong> after the download has finished so it won't consume website storage.</div>
                @endif
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
            $('.upload-form').each(function(idx, obj){
                var url = $(obj).attr('action');

                $(obj).find('.form-file').fileupload({
                    url: url,
                    dataType: 'json',
                    sequentialUploads: true,
                    add: function(e, data){
                        $(obj).find('.upload-messages').remove();

                        $.each(data.files, function (index, file) {
                            if (file.type.match('image.*')) {
                                data.context = $('<div class="col-xs-3"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style=""></div></div></div>');
                                data.context.appendTo($(obj).parent().find('.uploaded'));
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
                            $(obj).parent().find('.uploaded').sortable('reload');
                        }
                    },
                    fail: function(e, data){
                        if($(obj).find('.upload-messages').length < 1){
                            var $uploadMessages = $('<div class="upload-messages"></div>');
                            $uploadMessages.append('<ul></ul>');
                            $(obj).before($uploadMessages);
                        }else{
                            var $uploadMessages = $(obj).find('.upload-messages');
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

                $(obj).parent().find('.uploaded').sortable().bind('sortstop', function(e, ui){
                    var $photos = [];

                    $(obj).parent().find('.uploaded .uploaded-item').each(function(idx, obj){
                        $photos.push($(obj).data('attachment_id'));
                    });
                    $.ajax(
                        '{{ route('admin.property.media.reorder', ['id' => $property->id]) }}',
                        {
                            data: {
                                'type': $(obj).data('type'),
                                'photos': $photos,
                                '_token': $(obj).find('input[name="_token"]').val()
                            },
                            method: 'post',
                            success: function(data){

                            },
                            error: function(xhr){
                                console.log(xhr);
                                alert('Reorder error. Please try again.');
                            }
                        }
                    );
                });
            });
        });

        function addPhotoDelete($button)
        {
            $button.click(function(e){

            });
        }
    </script>
@endsection