@extends('frontend.master.layout')

@section('main_wrapper')
    <?php
    $page_class = 'general-page'.($main_banners?' general-page-slider':'');
    ?>
    <div class="@yield('page_class', $page_class)">
        @if($main_banners)
        <section class="slideshow-columns" id="slideshows">
            @foreach($main_banners as $main_banner)
            <div class="slide">
                @if($main_banner->link_path)<a href="{{ $main_banner->link_path }}" {{ $main_banner->target?'target="'.$main_banner->target.'"':'' }}>@endif
                <img src="{{ asset('assets/frontend/'.\GoProp\Models\MainBannerTranslation::$photosUploadPath.'/'.$main_banner->image) }}" class="img-responsive" alt="">
                @if($main_banner->link_path)</a>@endif
            </div>
            @endforeach
        </section>
        @endif

        @yield('content')
    </div>
@endsection