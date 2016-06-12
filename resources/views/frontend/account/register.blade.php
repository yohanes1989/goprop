@extends('frontend.master.layout_with_slider')

@section('slideshow_content')
    <img src="{{ asset('assets/frontend/images/banner-3.jpg') }}" class="img-responsive" alt="">
@endsection

@section('content')
    <section class="userform-columns">
        <div class="container">
            <div class="col-xs-12">
                @include('frontend.master.messages')

                <div class="header-area clearfix">
                    <h3 class="entry-title">{{ trans('account.register.page_title') }}</h3>
                    <div class="entry-register"><a href="{{ route('frontend.account.login') }}" class="btn btn-grey">{{ trans('account.register.login_btn') }}</a></div>
                </div>
            </div>
            <div class="col-xs-12 register-form-wrapper">
                <div class="login-with-area text-center">
                    <div class="loginwith-child">
                        <a href="{{ route('frontend.account.auth.facebook') }}" class="with-facebook clearfix">
                            <span class="icon"><i class="fa fa-facebook"></i></span>
                            <span class="text">Sign up with Facebook</span>
                        </a>
                    </div>
                    <div class="loginwith-child">
                        or
                    </div>
                    <div class="clearfix"></div>
                </div>

                {!! Form::model($model, ['route' => 'frontend.account.register.process', 'method' => 'POST', 'files' => true, 'id' => 'register-form']) !!}
                <div class="row">
                    <div class="col-md-2">&nbsp;</div>
                    <div class="col-md-8">
                        <div class="entry-desc">
                            <p>{{ trans('account.register.body_copy') }}</p>
                            <p>&nbsp;</p>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                {!! Form::label('profile_name', trans('forms.fields.name')) !!} <sup class="text-danger">*</sup>
                            </div>
                            <div class="col-sm-8">
                                {!! Form::text('profile[name]', null, ['class' => 'form-control', 'id' => 'profile_name']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                {!! Form::label('profile_mobile_phone_number', trans('forms.fields.mobile_phone_number')) !!} <sup class="text-danger">*</sup>
                            </div>
                            <div class="col-sm-8">
                                {!! Form::text('profile[mobile_phone_number]', null, ['class' => 'form-control', 'placeholder' => '', 'id' => 'profile_mobile_phone_number']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                {!! Form::label('email', trans('forms.fields.email')) !!} <sup class="text-danger">*</sup>
                            </div>
                            <div class="col-sm-8">
                                {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                {!! Form::label('password_confirmation', trans('forms.fields.password_confirmation')) !!} <sup class="text-danger">*</sup>
                            </div>
                            <div class="col-sm-8">
                                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                {!! Form::label('password', trans('forms.fields.password')) !!} <sup class="text-danger">*</sup>
                            </div>
                            <div class="col-sm-8">
                                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                {!! Form::label('extended_profile_referral_source', trans('extended_profile.referral_source_label')) !!} <sup class="text-danger">*</sup>
                            </div>
                            <div class="col-sm-8">
                                {!! Form::select('profile[extendedProfile][referral_source]', ['' => trans('forms.please_select')] + \GoProp\Models\ExtendedProfile::getReferralSourceLabel(), null, ['class' => 'form-control', 'id' => 'extended_profile_referral_source']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">&nbsp;</div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        @foreach($subscriptions as $subscription)
                            <div class="form-group clearfix" style="display: none;">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('subscriptions[]', $subscription->slug, in_array($subscription->slug, ['news-updates', 'partners-notification']), ['id' => $subscription->slug, 'class' => 'form-checkbox']) !!}
                                        {!! Form::label($subscription->slug, trans('account.register.subscriptions.'.$subscription->slug)) !!}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button class="btn btn-yellow">{{ trans('account.register.register_button') }}</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>

    <div class="clearfix"></div>
@endsection

@section('bottom_scripts')
    @parent

    {!! $validator->selector('#register-form') !!}
@stop