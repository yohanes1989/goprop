<div class="form-group">
    {!! Form::label('image', 'Image ('.$lang.') *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        @if(isset($translation) && $translation->image)
            <div>
                <img src="{{ url('images/small/'.$translation->image) }}" />
            </div>
        @endif
        {!! Form::file('image', array('class'=>'form-control', 'id' => 'image')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('title', 'Title ('.$lang.') *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::text('title', null, array('class'=>'form-control', 'id' => 'title', 'placeholder'=>'Title')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('url', 'URL to Display ('.$lang.') *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::text('url', old('url', $main_banner->url), array('class'=>'form-control', 'id' => 'url', 'placeholder'=>'URL to Display')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
    {!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}

    <a href="{{ route('admin.main_banner.index') }}" class="btn btn-warning">Cancel</a>
</div>