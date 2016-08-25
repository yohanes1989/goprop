@extends('frontend.master.layout_with_slider')

@section('slideshow_content')
    <img src="{{ asset('assets/frontend/images/banner-3.jpg') }}" class="img-responsive" alt="">
@endsection

@section('content')
    <div id="login-section" data-jump="1">
        {!! Form::open(['route' => 'frontend.account.login.process', 'method' => 'POST', 'class' => 'userform-columns']) !!}
        <div class="container">
            <div class="col-xs-12">
                @include('frontend.master.messages')

                <div class="header-area clearfix">
                    <h3 class="entry-title">{{ trans('account.login.page_title') }}</h3>
                    <div class="entry-register"><a href="{{ route('frontend.account.register') }}" class="btn btn-grey">{{ trans('account.login.register_btn') }}</a></div>
                </div>
            </div>
            <div class="col-xs-12 login-form-wrapper">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8">
                                <div class="login-with-area text-center">
                                    <div class="loginwith-child">
                                        <a href="{{ route('frontend.account.auth.facebook') }}" class="with-facebook clearfix">
                                            <span class="icon"><i class="fa fa-facebook"></i></span>
                                            <span class="text">Sign in with Facebook</span>
                                        </a>
                                    </div>
                                    <div class="loginwith-child">
                                        or
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="login-form-area">
                            <form class="form-horizontal" id="login-form">
                                <div class="form-group {{ $errors->has('email')?'has-error':'' }}">
                                    <div class="col-sm-4">
                                        {!! Form::label('email', trans('forms.fields.email'), ['class' => 'control-label']) !!} <sup class="text-danger">*</sup>
                                    </div>
                                    <div class="col-sm-8">
                                        {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) !!}

                                        <div class="help-block">
                                            @if($errors->has('email'))
                                                {{ $errors->get('email')[0] }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group {{ $errors->has('password')?'has-error':'' }}">
                                    <div class="col-sm-4">
                                        {!! Form::label('password', trans('forms.fields.password'), ['class' => 'control-label']) !!} <sup class="text-danger">*</sup>
                                    </div>
                                    <div class="col-sm-8">
                                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}

                                        <div class="help-block">
                                            @if($errors->has('password'))
                                                {{ $errors->get('password')[0] }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label col-sm-4">&nbsp;</label>
                                    <div class="col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('remember', true, ['id' => 'remember', 'class' => 'form-control']) !!}
                                                {{ trans('account.login.remember_me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-submit">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-8">
                                        <button class="btn btn-yellow">{{ trans('account.login.login_btn') }}</button>
                                        <a href="{{ route('frontend.account.email') }}" class="other-link"><small>{{ trans('account.login.forget_password') }}</small></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="clearfix"></div>
@endsection