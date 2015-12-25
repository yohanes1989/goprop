<div class="col-xs-3 text-center">
    <img class="img-responsive" src="{{ url('images/photo_thumbnail/'.$photo->filename) }}" />
    {!! Form::open(['route' => ['frontend.property.photos.delete', 'id' => $model->id, 'attachment_id' =>$photo->id]]) !!}
    <button type="submit" class="btn btn-transparent">{{ trans('forms.delete_btn') }}</button>
    {!! Form::close() !!}
</div>