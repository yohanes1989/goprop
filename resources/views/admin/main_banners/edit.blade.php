@extends('admin.layouts.master')

@section('title', 'Edit Main Banner ('.$lang.')')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.main_banner.index') }}"><i class="gi gi-picture"></i> Main Banners</a></li>
    <li>Edit Main Banner ({{ $lang }})</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <h4>Edit Main Banner ({{ $lang }})</h4>
        </div>

        {!! Form::model($translation, array('route' => ['admin.main_banner.update', 'lang' => $lang, 'id' => $main_banner->id], 'class' => 'form-horizontal', 'files' => TRUE)) !!}
            @include('admin.main_banners.create_form')
        {!! Form::close() !!}
    </div>
@endsection