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
    {!! Form::label('link_path', 'Link ('.$lang.')', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::text('link_path', null, array('class'=>'form-control', 'id' => 'link_path', 'placeholder'=>'Link')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('link_target', 'Link Target ('.$lang.')', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::select('link_target', ['_self' => 'Current Window', '_blank' => 'new Tab'], null, array('class'=>'form-control', 'id' => 'link_target')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('sort_order', 'Sort Order', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::text('sort_order', null, array('class'=>'form-control', 'id' => 'sort_order', 'placeholder'=>'Sort Order')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
    {!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}

    <a href="{{ route('admin.main_banner.index') }}" class="btn btn-warning">Cancel</a>
</div>