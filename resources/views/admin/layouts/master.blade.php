<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>
        @yield('title', config('app.default_title'))
    </title>

    <meta name="robots" content="noindex, nofollow">

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <!--<link rel="shortcut icon" href="{{ asset('assets/admin/img/favicon.png') }}">-->
    <!-- END Icons -->

    <!-- Stylesheets -->
    @section('styles')
    <!-- Bootstrap is included in its original form, unaltered -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/js/vendor/jquery-ui/jquery-ui.min.css') }}">

    <!-- Related styles of various icon packs and javascript plugins -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/plugins.css') }}">

    <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">

    <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

    <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
    <!--<link rel="stylesheet" href="{{ asset('assets/admin/css/themes/amethyst.css') }}">-->
    <!-- END Stylesheets -->

    <!-- Modernizr (Browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support it, eg IE8) -->
    <script src="{{ asset('assets/admin/js/vendor/modernizr-respond.min.js') }}"></script>
    @show
</head>
<!-- In the PHP version you can set the following options from the config file -->
<!--
    Add one of the following classes to the body element for the desirable feature:
    'sidebar-left-pinned'                         for a left pinned sidebar (always visible > 1200px)
    'sidebar-right-pinned'                        for a right pinned sidebar (always visible > 1200px)
    'sidebar-left-pinned sidebar-right-pinned'    for both sidebars pinned (always visible > 1200px)
-->
<body class="@yield('body_class', 'sidebar-left-pinned header-fixed-top')">

@section('body_content')
        <!-- Left Sidebar -->
<!-- In the PHP version you can set the following options from the config file -->
<!-- If you add the class .enable-hover, then a small portion of left sidebar will be visible and it can be opened with a mouse hover (> 1200px) (may affect website performance) -->
<div id="sidebar-left" class="enable-hover">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Wrapper for scrolling functionality -->
        <div class="sidebar-left-scroll">
            @section('sidebar_left')
                    <!-- Sidebar Navigation -->
                    <?php $menu = Menu::get('adminMenu'); ?>
                        @if($menu)
                        {!! $menu->asUl(['class' => 'sidebar-nav']) !!}
                        @endif
                    <!-- END Sidebar Navigation -->
            @show
        </div>
        <!-- END Wrapper for scrolling functionality -->
    </div>
    <!-- END Sidebar Content -->
</div>
<!-- END Left Sidebar -->

<!-- Right Sidebar -->
<!-- In the PHP version you can set the following options from the config file -->
<!-- If you add the class .enable-hover, then a small portion of right sidebar will be visible and it can be opened with a mouse hover (> 1200px) (may affect website performance) -->
<div id="sidebar-right">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        @if(Auth::check())
                <!-- User Info -->
        <div class="user-info">
            <div class="user-details">
                {{ Auth::user()->name }} (<a href="{{ action('Admin\Auth\AuthController@getLogout') }}">Log out</a>)<br>
                <em>{{  Auth::user()->email }}</em>
            </div>
        </div>
        <!-- END User Info -->
        @endif
    </div>
    <!-- END Sidebar Content -->
</div>
<!-- END Right Sidebar -->

<!-- Page Container -->
<!-- In the PHP version you can set the following options from the config file -->
<!-- Add the class .full-width for a full width page (100%, 1920px max width) -->
<div id="page-container" class="full-width">
    <!-- Header -->
    <!-- In the PHP version you can set the following options from the config file -->
    <!-- Add the class .navbar-default or .navbar-inverse for a light or dark header respectively -->
    <!-- Add the class .navbar-fixed-top or .navbar-fixed-bottom for a fixed header on top or bottom respectively -->
    <!-- If you add the class .navbar-fixed-top remember to add the class .header-fixed-top to <body> element -->
    <!-- If you add the class .navbar-fixed-bottom remember to add the class .header-fixed-bottom to <body> element -->
    <header class="navbar navbar-default navbar-fixed-top">
        <!-- Right Header Navigation -->
        <ul class="nav header-nav pull-right">
            <li>
                <a href="javascript:void(0)" id="sidebar-right-toggle">
                    <i class="fa fa-user"></i>
                </a>
            </li>
        </ul>
        <!-- END Right Header Navigation -->

        <!-- Left Header Navigation -->
        <ul class="nav header-nav pull-left">
            <li>
                <a href="javascript:void(0)" id="sidebar-left-toggle">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
        </ul>
        <!-- END Left Header Navigation -->

        <!-- Header Brand -->
        <a href="index.html" class="navbar-brand">
            <img src="{{ asset('assets/admin/logo.png') }}" alt="{{ config('app.default_title') }}">
            <span>{{ config('app.default_title') }}</span>
        </a>
        <!-- END Header Brand -->
    </header>
    <!-- END Header -->

    <!-- FX Container -->
    <!-- In the PHP version you can set the following options from the config file -->
    <!--
        All effects apply in resolutions larger than 1200px width
        Add one of the following classes to #fx-container for setting an effect to main content when one of the sidebars are opened
        'fx-none'           remove all effects (better website performance)
        'fx-opacity'        opacity effect
        'fx-move'           move effect
        'fx-push'           push effect
        'fx-rotate'         rotate effect
        'fx-push-move'      push-move effect
        'fx-push-rotate'    push-rotate effect
    -->
    <div id="fx-container" class="fx-opacity">
        <!-- Page content -->
        <div id="page-content" class="block">
            @section('breadcrumb')
                <ul class="breadcrumb breadcrumb-top">
                    <li><a href="{{ URL::route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    @yield('breadcrumb_list')
                </ul>
            @show

            @if(Session::has('messages'))
                <div class="alert alert-info alert-dismissable">
                    <ul>
                        @foreach(Session::get('messages') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!empty($errors->all()))
            <div class="alert alert-danger alert-dismissable">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div id="real-meat">
                @yield('content')
            </div>
        </div>
        <!-- END Page Content -->

        <!-- Footer -->
        <footer class="clearfix">
            <div class="pull-left">
                <span id="year-copy"></span> &copy; {{ config('app.default_title') }}
            </div>
        </footer>
        <!-- END Footer -->
    </div>
    <!-- END FX Container -->
</div>
<!-- END Page Container -->

<div id="modal-wrapper" class="modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 800px; width: 95%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body">
                Modal Content..
            </div>
        </div>
    </div>
</div>
@show

<!-- Scroll to top link, check main.js - scrollToTop() -->
<a href="javascript:void(0)" id="to-top"><i class="fa fa-angle-up"></i></a>

@section('bottom_scripts')
<!-- Bootstrap.js, Jquery plugins and custom Javascript code -->
<script>
    var global_vars = {
        'base_path': '{{ url('/') }}',
        'admin_path': '{{ url('/backend/') }}'
    };
</script>

<script src="{{ asset('assets/admin/js/vendor/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/vendor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins.js') }}"></script>
<script src="{{ asset('assets/admin/js/main.js') }}"></script>
<script src="{{ asset('assets/admin/js/goprop.js') }}"></script>
@show
</body>
</html>