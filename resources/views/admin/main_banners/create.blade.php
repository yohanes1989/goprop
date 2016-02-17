@extends('admin.layouts.master')

@section('title', 'Create Main Banner')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.main_banner.index') }}"><i class="gi gi-picture"></i> Main Banners</a></li>
    <li>Create Main Banner</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Create Main Banner ({{ $lang }})</h4>
        </div>

        {!! Form::model($main_banner,array('route' => ['admin.main_banner.store', 'lang' => $lang], 'class' => 'form-horizontal', 'files' => TRUE)) !!}
            @include('admin.main_banners.create_form')
        {!! Form::close() !!}
    </div>
@endsection