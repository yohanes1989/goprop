@extends('frontend.master.layout')

@section('main_wrapper')
    <div class="@yield('page_class', 'general-page general-page-slider')">
        @if($main_banner)
        <section class="slideshow-columns">
            <img src="{{ asset('assets/frontend/'.\GoProp\Models\MainBannerTranslation::$photosUploadPath.'/'.$main_banner->image) }}" class="img-responsive" alt="">
        </section>
        @endif

        @yield('content')
    </div>
@endsection