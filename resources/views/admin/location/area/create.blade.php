@extends('admin.layouts.master')

@section('title', 'Create Area')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.location.area.index') }}"><i class="gi gi-google_maps"></i> Areas</a></li>
    <li>Create Area</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Create Area</h4>
        </div>

        {!! Form::open(array('route' => ['admin.location.area.store', 'backUrl' => Request::get('backUrl', route('admin.location.area.index'))], 'class' => 'form-horizontal')) !!}
            @include('admin.location.area.create_form')
        {!! Form::close() !!}
    </div>
@endsection