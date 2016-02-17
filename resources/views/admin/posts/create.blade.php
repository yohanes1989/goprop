@extends('admin.layouts.master')

@section('title', 'Create Post')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.post.index') }}"><i class="fa fa-pencil"></i> Posts</a></li>
    <li>Create Post</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Create Post ({{ $lang }})</h4>
        </div>

        {!! Form::model($post,array('route' => ['admin.post.store', 'lang' => $lang], 'files' => TRUE, 'class' => 'form-horizontal')) !!}
            @include('admin.posts.create_form')
        {!! Form::close() !!}
    </div>
@endsection