@extends('frontend.master.layout')

@section('main_wrapper')
    <div class="@yield('page_class', 'general-page general-page-slider')">
        <section class="slideshow-columns">
            @yield('slideshow_content')
        </section>

        <div class="container">
            @include('frontend.master.messages')
        </div>

        @yield('content')
    </div>
@endsection