@extends('admin.layouts.master')

@section('title', 'Edit Area '.$area->subdistrict_name)

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.location.area.index') }}"><i class="gi gi-google_maps"></i> Areas</a></li>
    <li>Edit Area {{ $area->subdistrict_name }}</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Area {{ $area->subdistrict_name }}</h4>
        </div>

        {!! Form::open(array('route' => ['admin.location.area.update', 'id' => $area->subdistrict_id, 'backUrl' => Request::get('backUrl', route('admin.location.area.index'))], 'class' => 'form-horizontal')) !!}
            @include('admin.location.area.create_form')
        {!! Form::close() !!}
    </div>
@endsection