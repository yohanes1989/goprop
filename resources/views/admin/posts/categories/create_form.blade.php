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
    {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
    {!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}

    <a href="{{ route('admin.post.category.index') }}" class="btn btn-warning">Cancel</a>
</div>