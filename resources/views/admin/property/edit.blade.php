@extends('admin.layouts.master')

@section('title', 'Edit Property ('.$property->property_name.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.property.index') }}"><i class="gi gi-home"></i> Properties</a></li>
    <li>Edit Property ({{ $property->property_name }})</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Property ({{ $property->property_name }})</h4>
        </div>

        {!! Form::model($property,array('route' => ['admin.property.update', 'id' => $property->id], 'class' => 'form-horizontal','files'=>true)) !!}
            @include('admin.property.create_form')
        {!! Form::close() !!}
    </div>
@endsection