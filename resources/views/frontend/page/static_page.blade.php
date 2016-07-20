@extends('frontend.master.layout_with_slider')

@section('page_title', ProjectHelper::formatTitle(!empty($content->meta_title)?$content->meta_title:$content->title))

@section('meta_description', !empty($content->meta_description)?$content->meta_description:str_limit(trim(preg_replace('/\s\s+/', ' ', strip_tags($content->content))), 150))

@section('content')
    @if($content)
        {!! $content->content !!}
    @endif
@stop