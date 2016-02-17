@extends('frontend.master.layout')

@section('main_wrapper')
    <?php
    $page_class = 'general-page'.($main_banner?' general-page-slider':'');
    ?>
    <div class="@yield('page_class', $page_class)">
        @if($main_banner)
        <section class="slideshow-columns">
            <img src="{{ asset('assets/frontend/'.\GoProp\Models\MainBannerTranslation::$photosUploadPath.'/'.$main_banner->image) }}" class="img-responsive" alt="">
        </section>
        @endif

        @yield('content')
    </div>
@endsection