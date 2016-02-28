<div class="form-group">
    {!! Form::label('title', 'Name *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::text('title', old('title', $area->subdistrict_name), array('class'=>'form-control', 'id' => 'title', 'placeholder'=>'Title')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('city', 'City *', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::select('city', $cities, [old('city', $area->city_id)], array('class'=>'select-chosen form-control', 'id' => 'city')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('sort_order', 'Sort Order', array('class'=>'col-md-2 control-label')) !!}
    <div class="col-md-10">
        {!! Form::text('sort_order', old('sort_order', $area->sort_order), array('class'=>'form-control', 'id' => 'sort_order', 'placeholder'=>'Sort Order')) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
    {!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}

    <a href="{{ url(Request::get('backUrl', route('admin.location.area.index'))) }}" class="btn btn-warning">Cancel</a>
</div>