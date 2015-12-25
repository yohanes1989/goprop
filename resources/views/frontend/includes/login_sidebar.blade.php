@if(!\Illuminate\Support\Facades\Auth::check())
<div class="login-form-widget">
    <h4 class="entry-title">{{ trans('account.login.page_title') }}</h4>
    {!! Form::open(['method' => 'POST', 'class' => 'login-form-wrapper', 'route' => 'frontend.account.login.process']) !!}
        <div class="form-group">
            <input name="username" type="text" class="form-control" placeholder="{{ trans('forms.fields.username') }}" />
        </div>
        <div class="form-group">
            <input name="password" type="password" class="form-control" placeholder="{{ trans('forms.fields.password') }}" />
        </div>
        <div class="form-group">
            <input type="hidden" name="intended" value="{{ \Illuminate\Support\Facades\Request::fullUrl() }}" />
            <button type="submit" class="btn btn-yellow btn-shadow btn-submit">{{ trans('account.login.login_btn') }}</button>
        </div>
        <div class="form-detail">
            <a href="{{ route('frontend.account.register') }}">{{ trans('account.login.register_btn') }}</a>
            <a href="{{ route('frontend.account.email') }}">{{ trans('account.login.forget_password') }}</a>
            <!--
            <a href="" class="with-facebook clearfix">
                <span class="text">Sign in with Facebook</span>
                <span class="icon"><i class="fa fa-facebook"></i></span>
            </a>
            -->
        </div>
    {!! Form::close() !!}
</div>
@endif