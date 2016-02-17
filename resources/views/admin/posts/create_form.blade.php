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
    {!! Form::label('image', 'Image ('.$lang.')', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        @if(isset($translation) && $translation->image)
            <div>
                <img src="{{ url('images/small/'.$translation->image) }}" />
                <a href="#" class="remove-image"><i class="fa fa-times"></i></a>
                <input type="hidden" name="remove_image" value="0" />
            </div>
        @endif
        {!! Form::file('image', array('class'=>'form-control', 'id' => 'image')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('teaser', 'Teaser ('.$lang.') *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::textarea('teaser', null, array('class'=>'form-control ckeditor', 'id' => 'teaser', 'rows' => 5)) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('content', 'Content ('.$lang.') *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::textarea('content', null, array('class'=>'form-control ckeditor', 'id' => 'content', 'rows' => 10)) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('categories', 'Categories', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::select('categories[]', $categoryOptions, $post->categories->lists('id')->all(), array('style' => 'width: 100%;', 'class'=>'select-select2', 'multiple' => TRUE, 'id' => 'categories')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('status-select', 'Status *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::select('status', \GoProp\Models\Post::getStatusLabel(), null, array('id' => 'status-select','class'=>'form-control')) !!}
    </div>
</div>

<div class="form-group">
    @if(Request::get('translate') == 1)
        {!! Form::hidden('_translate', 1) !!}
    @endif
    {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
    {!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}

    <a href="{{ route('admin.post.index') }}" class="btn btn-warning">Cancel</a>
</div>