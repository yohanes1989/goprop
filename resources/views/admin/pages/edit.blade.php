@extends('admin.layouts.master')

@section('title', 'Edit Page '.$page->title.' ('.$lang.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.page.index') }}"><i class="fa fa-file-o"></i> Pages</a></li>
    <li>Edit Page {{ $page->title }} ({{ $lang }})</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Page {{ $page->title }} ({{ $lang }})</h4>
        </div>

        {!! Form::model($translation, array('route' => ['admin.page.update', 'lang' => $lang, 'id' => $page->id], 'class' => 'form-horizontal')) !!}
            @include('admin.pages.create_form')
        {!! Form::close() !!}
    </div>
@endsection