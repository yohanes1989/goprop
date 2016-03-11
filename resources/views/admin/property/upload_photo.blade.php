<div class="uploaded-item col-xs-3 text-center" data-attachment_id="{{ $photo->id }}">
    <img class="img-responsive" src="{{ url('images/photo_thumbnail/'.$photo->filename) }}?cb={{ time() }}" />
    {!! Form::open(['route' => ['admin.property.media.delete', 'id' => $property->id, 'attachment_id' =>$photo->id]]) !!}
    <a href="{{ route('admin.property.media.rotate', ['id' => $property->id, 'dir' => 'left', 'attachment_id' => $photo->id]) }}" class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Rotate Anti-clockwise"><i class="fa fa-rotate-left"></i></a>
    <a href="{{ route('admin.property.media.rotate', ['id' => $property->id, 'dir' => 'right', 'attachment_id' => $photo->id]) }}" class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Rotate Clockwise"><i class="fa fa-rotate-right"></i></a>
    <button type="submit" class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-remove"></i></button>
    {!! Form::close() !!}
</div>