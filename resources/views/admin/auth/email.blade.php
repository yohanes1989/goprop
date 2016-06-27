@extends('admin.layouts.master')

@section('body_class')@endsection

@section('body_content')
    <div id="login-container">
        <!-- Page Content -->
        <div id="page-content" class="block remove-margin">
            <!-- Login Title -->
            <div class="block-header">
                <div class="header-section">
                    <h1 class="text-center">Password Reset</h1>
                </div>
            </div>
            <!-- END Login Title -->

            <!-- Login Form -->
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.account.email.process') }}">
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

                <p>Please enter your email address.</p>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input value="{{ old('email') }}" type="email" id="login-email" name="email" class="form-control input-lg" placeholder="Email">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Reset</button>
                </div>
            </form>
            <!-- END Login Form -->
        </div>
        <!-- END Page Content -->
    </div>
@endsection