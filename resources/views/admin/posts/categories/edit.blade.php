@extends('admin.layouts.master')

@section('title', 'Edit Page '.$category->title.' ('.$lang.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.post.index') }}"><i class="fa fa-pencil"></i> Posts</a></li>
    <li><a href="{{ URL::route('admin.post.category.index') }}">Categories</a></li>
    <li>Edit Category {{ $category->title }} ({{ $lang }})</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Category {{ $category->title }} ({{ $lang }})</h4>
        </div>

        {!! Form::model($translation, array('route' => ['admin.post.category.update', 'lang' => $lang, 'id' => $category->id], 'class' => 'form-horizontal')) !!}
            @include('admin.posts.categories.create_form')
        {!! Form::close() !!}
    </div>
@endsection