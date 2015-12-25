@extends('frontend.master.layout_with_slider')

@section('slideshow_content')
    <img src="{{ asset('assets/frontend/images/banner-3.jpg') }}" class="img-responsive" alt="">
@endsection

@section('content')
    {!! Form::open(['route' => 'frontend.account.email.process', 'method' => 'POST', 'class' => 'userform-columns']) !!}
    <div class="container">
        <div class="col-xs-12">
            <div class="header-area clearfix">
                <h3 class="entry-title">{{ trans('account.forget_password.page_title') }}</h3>
                <div class="entry-register"><a href="{{ route('frontend.account.register') }}" class="btn btn-grey">{{ trans('account.login.register_btn') }}</a></div>
            </div>
            <div class="entry-desc">
                <p>{{ trans('account.forget_password.body_copy') }}</p>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-6">
                    <div class="login-form-area">
                        <p>&nbsp;</p>
                        <form class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-4 align-right">
                                    {!! Form::label('email', trans('forms.fields.email'), ['class' => 'control-label']) !!} <sup class="text-danger">*</sup>
                                </div>
                                <div class="col-sm-8">
                                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group form-submit">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8">
                                    <button class="btn btn-yellow">{{ trans('account.forget_password.submit_btn') }}</button>
                                    <a href="{{ route('frontend.account.login') }}" class="other-link"><small class="text-muted"><i>{{ trans('account.forget_password.back_to_login_btn') }}</i></small></a>
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

    <div class="clearfix"></div>
@endsection