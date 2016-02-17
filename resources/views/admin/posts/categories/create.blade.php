@extends('admin.layouts.master')

@section('title', 'Create Category')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.post.index') }}"><i class="fa fa-pencil"></i> Posts</a></li>
    <li><a href="{{ URL::route('admin.post.category.index') }}">Categories</a></li>
    <li>Create Category</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Create Category ({{ $lang }})</h4>
        </div>

        {!! Form::model($category, array('route' => ['admin.post.category.store', 'lang' => $lang], 'class' => 'form-horizontal')) !!}
            @include('admin.posts.categories.create_form')
        {!! Form::close() !!}
    </div>
@endsection