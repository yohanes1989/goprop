@extends('admin.layouts.master')

@section('title', 'Create Testimonial')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.testimonial.index') }}"><i class="fa fa-comment"></i> Testimonials</a></li>
    <li>Create Testimonial</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Create Testimonial ({{ $lang }})</h4>
        </div>

        {!! Form::model($testimonial,array('route' => ['admin.testimonial.store', 'lang' => $lang], 'class' => 'form-horizontal', 'files' => TRUE)) !!}
            @include('admin.testimonials.create_form')
        {!! Form::close() !!}
    </div>
@endsection