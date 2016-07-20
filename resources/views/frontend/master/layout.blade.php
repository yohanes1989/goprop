@if(\Illuminate\Support\Facades\Request::ajax())
    <div id="popup-wrapper">
        @yield('content')
    </div>
@else
<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
    <head>
        <meta charset="UTF-8">
        <title>@yield('page_title', 'Go Prop')</title>

        <meta name="description" content="@yield('meta_description', config('app.default_description'))">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @if($localeCode != LaravelLocalization::getCurrentLocale())
        <!--<link rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">-->
        @endif
        @endforeach

        @section('open_graph')
            <meta property="fb:app_id" content="{{ config('app.fb_app_id') }}" />
            <meta property="og:site_name" content="{{ config('app.default_title') }}" />
        @show

        @section('styles')
        <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/font-awesome-4.4.0/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/owl.carousel.2.0.0-beta.2.4/assets/owl.carousel.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/bootstrap-slider/css/bootstrap-slider.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/fancybox/jquery.fancybox.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/flexslider/flexslider.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/fullcalendar/fullcalendar.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/flag-icon.min.css') }}">
        <link type="text/css" rel="stylesheet" href="{{ asset('assets/frontend/vendor/lightGallery/dist/css/lightgallery.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/ion.rangeSlider/css/ion.rangeSlider.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/ion.rangeSlider/css/ion.rangeSlider.goprop.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/style.css') }}">
        @show

        @if(!env('APP_DEBUG'))
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
                n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                    document,'script','https://connect.facebook.net/en_US/fbevents.js');

            fbq('init', '100791517030051');
            fbq('track', "PageView");</script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id=100791517030051&ev=PageView&noscript=1"
                    /></noscript>
        <!-- End Facebook Pixel Code -->
        @endif
    </head>

    <body class="@yield('body_class')">
        @if(!(Auth::user() && Auth::user()->is('administrator')) && !App::isLocal())
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-75289751-1', 'auto');
                ga('send', 'pageview');

            </script>
        @endif

        <header id="header">
            <div class="container">
                <div class="brand col-sm-3 col-xs-6">
                    <a href="{{ route('frontend.page.home') }}"><img src="{{ asset('assets/frontend/images/logo.png') }}" class="img-responsive" alt=""></a>
                </div>
                <div class="col-sm-4 col-xs-6 responsive-btn-area">
                    <a href="javascript:;" id="responsive-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <div class="menu-section">
                        @if(\Illuminate\Support\Facades\Auth::check())
                        <ul class="list-inline">
                            <li class="text-yellow">{{ trans('account.interface.greeting') }} <a href="{{ route('frontend.account.dashboard') }}"><strong>{{ \Illuminate\Support\Facades\Auth::user()->getName() }}</strong></a></li>
                            <li><a href="{{ route('frontend.account.logout') }}" class="btn btn-yellow btn-transparent btn-xs text-uppercase">{{ trans('account.interface.logout_btn') }}</a></li>
                        </ul>
                        @else
                        <ul class="list-inline">
                            <li><a href="{{ route('frontend.account.register') }}" class="btn btn-yellow btn-transparent btn-xs text-uppercase">{{ trans('account.interface.register_btn') }}</a></li>
                            <li>or</li>
                            <li><a href="{{ route('frontend.account.login') }}" class="btn btn-yellow btn-transparent btn-xs text-uppercase">{{ trans('account.interface.login_btn') }}</a></li>
                        </ul>
                        @endif

                        <ul class="list-inline">
                            <li><a href="https://www.facebook.com/goprop.co.id" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://www.instagram.com/gopropid" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            <li><a hreflang="id" href="{{ LaravelLocalization::getLocalizedURL('id') }}"><span class="flag-icon flag-icon-id"></span></a></li>
                            <li><a hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en') }}"><span class="flag-icon flag-icon-gb"></span></a></li>
                        </ul>
                    </div>
                    <div class="main-menu-wrapper">
                        <nav id="main-nav">
                            <ul>
                                <li><a href="{{ route('frontend.page.static_page', ['identifier' => 'get-started']) }}">{{ trans('menu.get_started') }}</a></li>
                                <li><a href="{{ route('frontend.property.create') }}">{{ trans('menu.upload_property') }}</a></li>
                                <li><a href="{{ route('frontend.property.search') }}" data-replace-href="{{ route('frontend.property.simple_search') }}" class="ajax_popup fancybox.ajax">{{ trans('menu.property_search') }}</a></li>
                                <li><a href="{{ route('frontend.page.resources') }}">{{ trans('menu.resources') }}</a></li>
                                <li><a href="{{ route('frontend.page.static_page', ['identifier' => 'about-goprop']) }}">{{ trans('menu.about') }}</a></li>
                                <li><a href="{{ route('frontend.page.contact') }}">{{ trans('menu.contact') }}</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        @section('main_wrapper')
            <div class="@yield('page_class', 'general-page')">
                <div class="container">
                @include('frontend.master.messages')
                    </div>

                @yield('content')
            </div>
        @show

        <footer id="footer">
            <div class="footer-top">
                <div class="container">
                    <div class="footer-child col-sm-3">
                        <div class="footer-content">
                            <ul class="list-unstyled">
                                <li><a href="{{ route('frontend.page.static_page', ['identifier' => 'get-started']) }}">{{ trans('menu.get_started') }}</a></li>
                                <li><a href="{{ route('frontend.property.create') }}">{{ trans('menu.upload_property') }}</a></li>
                                <li><a href="{{ route('frontend.property.search') }}">{{ trans('menu.property_search') }}</a>
                                    <!--
                                    <ul class="list-unstyled">
                                        <li><a href="{{ route('frontend.property.search') }}">All Listing</a></li>
                                        <li><a href="{{ route('frontend.property.search', ['exclusive' => true]) }}">Exclusive Listing</a></li>
                                    </ul>
                                    -->
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-child col-sm-3">
                        <div class="footer-content">
                            <ul class="list-unstyled">
                                <li><a href="{{ route('frontend.page.resources') }}">{{ trans('menu.resources') }}</a></li>
                                <li><a href="{{ route('frontend.page.static_page', ['identifier' => 'about-goprop']) }}">{{ trans('menu.about') }}</a></li>
                                <li><a href="{{ route('frontend.page.contact') }}">{{ trans('menu.contact') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="footer-child col-sm-4">
                        <div class="footer-content text-center">
                            <div class="menu-listing">
                                <!--
                                <ul class="list-inline">
                                    <li><a href=""><img src="{{ asset('assets/frontend/images/app-store.png') }}"></a></li>
                                    <li><a href=""><img src="{{ asset('assets/frontend/images/google-play.png') }}"></a></li>
                                </ul>
                                -->
                                <ul class="list-inline social-links">
                                    <li><a href="https://www.facebook.com/goprop.co.id" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://www.instagram.com/gopropid" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="col-xs-12">
                        <small>Copyright {{ date('Y') }} www.goprop.co.id</small>
                    </div>
                </div>
            </div>
        </footer>

        @section('bottom_scripts')
        <script>
            var global_vars = {
                'base_path': '{{ url('/') }}',
                'currency': 'IDR',
                'time': '{{ date('Y-m-d H:i:s') }}'
            };
        </script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/jquery/jquery-1.11.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/moment/min/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/owl.carousel.2.0.0-beta.2.4/owl.carousel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/bootstrap-slider/js/bootstrap-slider.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/fancybox/jquery.fancybox.pack.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/flexslider/jquery.flexslider-min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/fullcalendar/fullcalendar.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/accounting.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/lightGallery/dist/js/lightgallery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/lightGallery/dist/js/lg-autoplay.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/lightGallery/dist/js/lg-hash.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/lightGallery/dist/js/lg-pager.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/lightGallery/dist/js/lg-thumbnail.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/ion.rangeSlider/js/ion.rangeSlider.js') }}"></script>
        <script src="{{ asset('assets/frontend/vendor/jquery-inputmask/jquery.inputmask.bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/js/app.js') }}"></script>
        @show
    </body>
</html>
@endif