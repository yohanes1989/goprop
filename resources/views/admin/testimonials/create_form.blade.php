<div class="form-group">
    {!! Form::label('image', 'Image', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        @if($testimonial->image)
            <div>
                <img src="{{ url('images/profile_picture/'.$testimonial->image) }}" />
                <a href="#" class="remove-image"><i class="fa fa-times"></i></a>
                <input type="hidden" name="remove_image" value="0" />
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
    {!! Form::label('content', 'Content ('.$lang.') *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::textarea('content', null, array('class'=>'form-control', 'id' => 'content', 'rows' => 4)) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
    {!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}

    <a href="{{ route('admin.testimonial.index') }}" class="btn btn-warning">Cancel</a>
</div>