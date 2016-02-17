@extends('frontend.master.layout_with_slider')

@section('page_title', ProjectHelper::formatTitle($content->title))

@section('content')
    @if($content)
        {!! $content->content !!}
    @endif

@include('frontend.includes.partner')
@stop