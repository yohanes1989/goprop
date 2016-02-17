@extends('frontend.master.layout_with_slider')

@section('content')
    {!! Form::open(['route' => 'frontend.account.reset.process', 'method' => 'POST', 'class' => 'userform-columns']) !!}
    <div class="container">
        <div class="col-xs-12">
            @include('frontend.master.messages')

            <div class="header-area clearfix">
                <h3 class="entry-title">{{ trans('account.reset.page_title') }}</h3>
            </div>
            <div class="entry-desc">
                <p>{{ trans('account.reset.body_copy') }}</p>
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
                                <div class="col-sm-5 align-right">
                                    {!! Form::label('email', trans('forms.fields.email'), ['class' => 'control-label']) !!} <sup class="text-danger">*</sup>
                                </div>
                                <div class="col-sm-7">
                                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-5 align-right">
                                    {!! Form::label('password', trans('forms.fields.password'), ['class' => 'control-label']) !!} <sup class="text-danger">*</sup>
                                </div>
                                <div class="col-sm-7">
                                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-5 align-right">
                                    {!! Form::label('password_confirmation', trans('forms.fields.password_confirmation'), ['class' => 'control-label']) !!} <sup class="text-danger">*</sup>
                                </div>
                                <div class="col-sm-7">
                                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) !!}
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group form-submit">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-7">
                                    {!! Form::hidden('token', $token) !!}
                                    <button type="submit" class="btn btn-yellow">{{ trans('account.reset.submit_btn') }}</button>
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