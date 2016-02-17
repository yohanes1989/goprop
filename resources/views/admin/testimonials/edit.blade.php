@extends('admin.layouts.master')

@section('title', 'Edit Page ('.$lang.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.testimonial.index') }}"><i class="fa fa-comment"></i> Testimonials</a></li>
    <li>Edit Testimonial ({{ $lang }})</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Testimonial ({{ $lang }})</h4>
        </div>

        {!! Form::model($translation, array('route' => ['admin.testimonial.update', 'lang' => $lang, 'id' => $testimonial->id], 'class' => 'form-horizontal', 'files' => TRUE)) !!}
            @include('admin.testimonials.create_form')
        {!! Form::close() !!}
    </div>
@endsection