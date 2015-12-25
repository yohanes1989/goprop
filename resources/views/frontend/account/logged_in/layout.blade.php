@extends('frontend.master.layout')

@section('main_wrapper')
    <div class="@yield('page_class', 'general-page my-account-page')">
        <div class="col-xs-4 sidebar-menu-wrapper">
            @include('frontend.account.logged_in.sidebar')
        </div>

        <div class="col-xs-8 user-content-wrapper">
            <div class="user-content-begin">
                <div class="col-sm-12">
                    @include('frontend.master.messages')

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@endsection