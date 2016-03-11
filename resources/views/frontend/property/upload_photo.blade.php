<div class="uploaded-item col-xs-6 col-md-3" data-attachment_id="{{ $photo->id }}">
    <img class="img-responsive" src="{{ url('images/photo_thumbnail/'.$photo->filename) }}?cb={{ time() }}" />
    {!! Form::open(['route' => ['frontend.property.photos.delete', 'id' => $model->id, 'attachment_id' =>$photo->id]]) !!}
    <a href="{{ route('frontend.property.photos.rotate', ['dir' => 'left', 'id' => $model->id, 'attachment_id' =>$photo->id]) }}">
        <i class="fa fa-rotate-left"></i>
    </a>
    <a href="{{ route('frontend.property.photos.rotate', ['dir' => 'right', 'id' => $model->id, 'attachment_id' =>$photo->id]) }}">
        <i class="fa fa-rotate-right"></i>
    </a>
    <button type="submit" class="btn btn-transparent"><i class="fa fa-remove"></i></button>
    {!! Form::close() !!}
</div>