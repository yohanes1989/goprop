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
            <form class="form-horizontal" role="form" method="POST" action="{{ action('Portal\Auth\AuthController@postLogin') }}">
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

                @if (Session::has('status'))
                    <div class="alert alert-info">
                        {{ Session::get('status') }}
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

                        <input type="checkbox" id="login-remember" name="remember" value="1" hidden />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-8">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-default disabled">Remember me?</button>
                            <button type="button" class="btn btn-sm btn-default" data-toggle="button" id="btn-remember"><i class="fa fa-check"></i></button>
                        </div>
                        <br/><br/>
                        <a href="{{ route('frontend.page.home') }}" class="other-link"><small>GoProp.co.id</small></a> | <a href="{{ route('portal.account.email') }}" class="other-link"><small>Forget your password?</small></a>
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

@section('bottom_scripts')
    @parent

    <!-- Javascript code only for this page -->
    <script>
        $(function(){
            /* Save buttons (remember me and terms) and hidden checkboxes in variables */
            var checkR  = $('#login-remember'),
                    btnR = $('#btn-remember');

            // Add the 'active' class to button if their checkbox has the property 'checked'
            if (checkR.prop('checked')) btnR.addClass('active');

            // Toggle 'checked' property of hidden checkboxes when buttons are clicked
            btnR.on('click', function(){ checkR.prop('checked', !checkR.prop('checked')); });
        });
    </script>
@stop