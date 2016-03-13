@extends('frontend.master.layout')

@section('main_wrapper')
    <div class="@yield('page_class', 'general-page my-account-page')">
        <div class="col-sm-4 sidebar-menu-wrapper">
            @include('frontend.account.logged_in.sidebar')

            <a href="#" class="visible-xs sidebar-close sidebar-toggle">{{ trans('account.sidebar.account_navigation') }}</a>
        </div>

        <div class="col-sm-8 user-content-wrapper">
            <div class="user-content-begin">
                @include('frontend.master.messages')

                @yield('content')
            </div>
        </div>
    </div>
@endsection