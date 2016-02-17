@extends('admin.layouts.master')

@section('title', 'Create Page')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.page.index') }}"><i class="fa fa-file-o"></i> Pages</a></li>
    <li>Create Page</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Create Page ({{ $lang }})</h4>
        </div>

        {!! Form::model($page,array('route' => ['admin.page.store', 'lang' => $lang], 'class' => 'form-horizontal')) !!}
            @include('admin.pages.create_form')
        {!! Form::close() !!}
    </div>
@endsection