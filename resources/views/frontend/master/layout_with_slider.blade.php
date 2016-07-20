@extends('frontend.master.layout')

@section('main_wrapper')
    <?php
    $page_class = 'general-page'.($main_banners?' general-page-slider':'');
    ?>
    <div class="@yield('page_class', $page_class)">
        @if($main_banners)
        <section class="slideshow-columns" id="slideshows">
            @foreach($main_banners as $main_banner)
            <div class="slide"><img src="{{ asset('assets/frontend/'.\GoProp\Models\MainBannerTranslation::$photosUploadPath.'/'.$main_banner->image) }}" class="img-responsive" alt=""></div>
            @endforeach
        </section>
        @endif

        @yield('content')
    </div>
@endsection