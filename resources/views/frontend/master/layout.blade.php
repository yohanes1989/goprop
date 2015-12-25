@if(\Illuminate\Support\Facades\Request::ajax())
    <div id="popup-wrapper">
        @yield('content')
    </div>
@else
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@yield('page_title', 'Go Prop')</title>

        <meta name="description" content="@yield('meta_description')">
        <meta name="keywords" content="@yield('meta_keywords')">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        @section('styles')
        <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/font-awesome-4.4.0/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/owl.carousel.2.0.0-beta.2.4/assets/owl.carousel.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/bootstrap-slider/css/bootstrap-slider.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/fancybox/jquery.fancybox.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/flexslider/flexslider.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/vendor/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/style.css') }}">
        @show
    </head>

    <body class="@yield('body_class')">
        <header id="header">
            <div class="container">
                <div class="brand col-sm-3 col-xs-6">
                    <a href="{{ route('frontend.page.home') }}"><img src="{{ asset('assets/frontend/images/logo.png') }}" class="img-responsive" alt=""></a>
                </div>
                <div class="col-sm-4 col-xs-6 responsive-btn-area">
                    <a href="javascript:;" class="responsive-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <div class="menu-section hidden-xs">
                        @if(\Illuminate\Support\Facades\Auth::check())
                        <ul class="list-inline">
                            <li class="text-yellow">{{ trans('account.interface.greeting') }} <a href="{{ route('frontend.account.dashboard') }}"><strong>{{ \Illuminate\Support\Facades\Auth::user()->username }}</strong></a></li>
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
                            <li><a href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                            <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                    <div class="main-menu-wrapper">
                        <nav id="main-nav">
                            <ul>
                                <li><a href="get-started.php">Get Started</a></li>
                                <li><a href="{{ route('frontend.property.create') }}">Upload Property</a></li>
                                <li><a href="{{ route('frontend.property.search') }}" data-replace-href="{{ route('frontend.property.simple_search') }}" class="ajax_popup fancybox.ajax">Property Search</a></li>
                                <li><a href="">How It Works</a></li>
                                <li><a href="resources.php">Resources</a></li>
                                <li><a href="about.php">About</a></li>
                                <li><a href="contact.php">Contact</a></li>
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
                                <li><a href="">Get Started</a></li>
                                <li><a href="">Upload Property</a></li>
                                <li><a href="{{ route('frontend.property.search') }}">Property Search</a>
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
                                <li><a href="">How It Works</a></li>
                                <li><a href="">Resources</a></li>
                                <li><a href="">About</a></li>
                                <li><a href="">Contact</a></li>
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
                                    <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                    <li><a href=""><i class="fa fa-twitter"></i></a></li>
                                    <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="col-xs-12">
                        <small>Copyright 2015 www.goprop.co.id</small>
                    </div>
                </div>
            </div>
        </footer>

        @section('bottom_scripts')
        <script>
            var global_vars = {
                'base_path': '{{ url('/') }}',
                'currency': 'IDR'
            };
        </script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/jquery/jquery-1.11.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/moment/min/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/owl.carousel.2.0.0-beta.2.4/owl.carousel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/bootstrap-slider/js/bootstrap-slider.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/fancybox/jquery.fancybox.pack.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/flexslider/jquery.flexslider-min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/vendor/accounting.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/frontend/js/app.js') }}"></script>
        @show
    </body>
</html>
@endif