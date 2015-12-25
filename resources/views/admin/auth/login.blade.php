@extends('admin.layouts.master')

@section('body_class')@endsection

@section('body_content')
    <div id="login-container">
        <!-- Page Content -->
        <div id="page-content" class="block remove-margin">
            <!-- Login Title -->
            <div class="block-header">
                <div class="header-section">
                    <h1 class="text-center">Please Login</small></h1>
                </div>
            </div>
            <!-- END Login Title -->

            <!-- Login Form -->
            <form class="form-horizontal" role="form" method="POST" action="{{ action('Admin\Auth\AuthController@postLogin') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <div class="col-xs-12">
                        <input value="{{ old('email') }}" type="email" id="login-email" name="email" class="form-control input-lg" placeholder="Email">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input type="password" id="login-password" name="password" class="form-control input-lg" placeholder="Password">

                        <!--
                        Hidden checkbox. Its checked property will be toggled every time the remember me (#btn-remember) button is clicked (js code at the bottom)
                        You can add the checked property by default (the button will be enabled automatically)
                        -->
                        <input type="checkbox" id="login-remember" name="remember" hidden="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-8">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-default disabled">Remember me?</button>
                            <button type="button" class="btn btn-sm btn-default" data-toggle="button" id="btn-remember"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                    <div class="col-xs-4 text-right">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Login</button>
                    </div>
                </div>
            </form>
            <!-- END Login Form -->
        </div>
        <!-- END Page Content -->
    </div>
@endsection
