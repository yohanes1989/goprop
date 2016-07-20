@extends('frontend.master.layout_with_slider')

@section('page_title', ProjectHelper::formatTitle(!empty($post->meta_title)?$post->meta_title:$post->title))

@section('meta_description', !empty($post->meta_description)?$post->meta_description:str_limit(trim(preg_replace('/\s\s+/', ' ', strip_tags($post->content))), 150))

@section('content')
    <section class="article-columns">
        <div class="container">
            <div class="col-md-12">
                <header class="header-area">
                    <h1 class="entry-title">{{ $title }}</h1>
                    <div class="entry-meta">{{ $post->created_at->format('l, j F Y') }}</div>
                </header>
            </div>

            <div class="col-sm-8">
                <div class="article-list">
                    <div class="article-child">
                        <div class="img-wrap">
                            @if($post->image)
                                <p><img src="{{ asset('images/photo_gallery/'.$post->image) }}" alt="" class="img-responsive"></p>
                            @endif
                        </div>

                        <div class="entry-content">
                            {!! $post->content !!}
                        </div>

                        <div class="entry-below">
                            <div class="tags-list clearfix">
                                <span class="icon"><i class="fa fa-folder"></i></span>
                                <ul class="list-unstyled">
                                    @foreach($post->categories as $category)
                                        <li><a href="{{ route('frontend.page.resources.category', ['category' => $category->slug]) }}">{{ $category->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="widget-child">
                    <div class="widget-title">
                        <h3 class="entry-title">{{ trans('resources.categories') }}</h3>
                    </div>
                    <div class="category-list-widget">
                        <ul class="list-unstyled">
                            @foreach($categories as $category)
                            <li><a href="{{ route('frontend.page.resources.category', ['category' => $category->slug]) }}">{{ $category->title }}</a> ({{ $category->postsCount }})</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop