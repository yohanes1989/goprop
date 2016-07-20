<div class="form-group">
    {!! Form::label('identifier', 'Identifier *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::text('identifier', old('identifier', $page->identifier), array('class'=>'form-control', 'id' => 'identifier', 'placeholder'=>'Identifier')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('title', 'Title ('.$lang.') *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::text('title', null, array('class'=>'form-control', 'id' => 'title', 'placeholder'=>'Title')) !!}
    </div>
</div>

@if(isset($translation) && !empty($translation->slug))
<div class="form-group">
    {!! Form::label('slug', 'Slug ('.$lang.') *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::text('slug', null, array('class'=>'form-control', 'disabled' => TRUE, 'id' => 'slug', 'placeholder'=>'Slug')) !!}
    </div>
</div>
@endif

<div class="form-group">
    {!! Form::label('content', 'Content ('.$lang.') *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::textarea('content', null, array('class'=>'form-control ckeditor', 'id' => 'content', 'rows' => 10)) !!}
    </div>
</div>

<hr/>

<div class="form-group">
    {!! Form::label('meta_title', 'Meta Title ('.$lang.')', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::text('meta_title', null, array('class'=>'form-control', 'id' => 'meta_title')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('meta_description', 'Meta Description ('.$lang.')', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::textarea('meta_description', null, array('class'=>'form-control', 'id' => 'meta_description', 'rows' => 3)) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
    {!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}

    <a href="{{ route('admin.page.index') }}" class="btn btn-warning">Cancel</a>
</div>