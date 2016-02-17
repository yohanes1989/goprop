@extends('frontend.master.layout_with_slider')

@section('page_title', ProjectHelper::formatTitle($title))

@section('content')
    <section class="article-columns">
        <div class="container">
            <div class="col-md-12">
                <header class="header-area">
                    <h2 class="entry-title">{{ $title }}</h2>
                </header>
            </div>

            <div class="col-sm-8">
                <div class="article-list">
                    @foreach($paginator as $post)
                    <div class="article-child">
                        <header class="entry-header">
                            <h3 class="entry-title"><a href="{{ route('frontend.page.resources.post', ['slug' => $post->slug]) }}">{{ $post->title }}</a></h3>
                            <div class="entry-meta">{{ $post->created_at->format('l, j F Y') }}</div>
                        </header>
                        <div class="row">
                            <div class="img-wrap col-sm-5">
                                @if($post->image)
                                <img src="{{ asset('images/property_thumbnail/'.$post->image) }}" alt="" class="img-responsive">
                                @endif
                            </div>
                            <div class="entry-content col-sm-7">
                                {!! $post->teaser?$post->teaser:$post->content !!}
                            </div>
                        </div>
                        <div class="entry-below">
                            <!--
                            <div class="tags-list clearfix">
                                <span class="icon"><i class="fa fa-tags"></i></span>
                                <ul class="list-unstyled">
                                    <li><a href="">online estate agent</a></li>
                                    <li><a href="">house sale</a></li>
                                </ul>
                            </div>
                            -->
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
                    @endforeach
                </div>

                @include('frontend.master.pagination')
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