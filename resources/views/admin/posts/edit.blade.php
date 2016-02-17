@extends('admin.layouts.master')

@section('title', 'Edit Post '.$post->title.' ('.$lang.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.post.index') }}"><i class="fa fa-pencil"></i> Posts</a></li>
    <li>Edit Post {{ $post->title }} ({{ $lang }})</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Post {{ $post->title }} ({{ $lang }})</h4>
        </div>

        {!! Form::model($translation, array('route' => ['admin.post.update', 'lang' => $lang, 'id' => $post->id], 'files' => TRUE, 'class' => 'form-horizontal')) !!}
            @include('admin.posts.create_form')
        {!! Form::close() !!}
    </div>
@endsection