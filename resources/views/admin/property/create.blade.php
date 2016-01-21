@extends('admin.layouts.master')

@section('title', 'Create Property')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.property.index') }}"><i class="gi gi-home"></i> Properties</a></li>
    <li>Create Property</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Create Property</h4>
        </div>

        {!! Form::model($property,array('route' => ['admin.property.store'], 'class' => 'form-horizontal','files'=>true)) !!}
            @include('admin.property.create_form')
        {!! Form::close() !!}
    </div>
@endsection