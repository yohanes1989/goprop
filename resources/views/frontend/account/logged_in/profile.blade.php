@extends('frontend.account.logged_in.layout')

@section('content')
    <header class="header-area">
        <h3 class="entry-title">{{ trans('account.profile.page_title') }}</h3>
    </header>
    <div class="entry-content">
        <p>{{ trans('account.profile.body_copy') }} <sup class="text-danger">*</sup> {{ trans('forms.required_fields') }}</p>
    </div>

    <div class="register-form-wrapper">
        {!! Form::model($model, ['route' => 'frontend.account.profile.process', 'method' => 'POST', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('email', trans('forms.fields.email')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                        </div>
                    </div>
                    <!--
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('username', trans('forms.fields.username')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::text('username', null, ['class' => 'form-control', 'id' => 'username']) !!}
                            </div>
                    </div>
                        -->
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('password', trans('forms.fields.password')) !!}
                        </div>
                        <div class="col-sm-8">
                            {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('password_confirmation', trans('forms.fields.password_confirmation')) !!}
                        </div>
                        <div class="col-sm-8">
                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <hr class="form-divider" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('profile_title', trans('forms.fields.title')) !!}
                        </div>
                        <div class="col-sm-8">
                            {!! Form::select('profile[title]', ['' => trans('forms.please_select')] + \GoProp\Models\Profile::getTitleLabel(), null, ['class' => 'form-control', 'id' => 'profile_title']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('profile_first_name', trans('forms.fields.first_name')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::text('profile[first_name]', null, ['class' => 'form-control', 'id' => 'profile_first_name']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('profile_last_name', trans('forms.fields.last_name')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::text('profile[last_name]', null, ['class' => 'form-control', 'id' => 'profile_last_name']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('profile_mobile_phone_number', trans('forms.fields.mobile_phone_number')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::text('profile[mobile_phone_number]', null, ['class' => 'form-control', 'id' => 'profile_mobile_phone_number']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('profile_home_phone_number', trans('forms.fields.home_phone_number')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::text('profile[home_phone_number]', null, ['class' => 'form-control', 'id' => 'profile_home_phone_number']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('profile_address', trans('forms.fields.address')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::textarea('profile[address]', null, ['class' => 'form-control', 'rows' => 3, 'id' => 'profile_address']) !!}
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('profile_province', trans('forms.fields.province')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::select('profile[province]', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getProvinces(true), null, ['class' => 'form-control form-address-selector-province', 'id' => 'profile_province']) !!}
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('profile_city', trans('forms.fields.city')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::select('profile[city]', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getCities($model->profile->province, true), null, ['class' => 'form-control form-address-selector-city', 'id' => 'profile_city']) !!}
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('profile_subdistrict', trans('forms.fields.subdistrict')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::select('profile[subdistrict]', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getSubdistricts($model->profile->city, true), null, ['class' => 'form-control form-address-selector-subdistrict', 'id' => 'profile_subdistrict']) !!}
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('profile_postal_code', trans('forms.fields.postal_code')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::text('profile[postal_code]', null, ['class' => 'form-control', 'id' => 'profile_postal_code']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <hr class="form-divider" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('extended_profile_property_sell', trans('extended_profile.property_to_sell_label')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::select('profile[extendedProfile][property_to_sell]', ['' => trans('forms.please_select')] + \GoProp\Models\ExtendedProfile::getPropertySellLabel(), null, ['class' => 'form-control', 'id' => 'extended_profile_property_sell']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="form-group clearfix">
                        <div class="col-sm-4">
                            {!! Form::label('extended_profile_property_let', trans('extended_profile.property_to_rent_label')) !!} <sup class="text-danger">*</sup>
                        </div>
                        <div class="col-sm-8">
                            {!! Form::select('profile[extendedProfile][property_to_let]', ['' => trans('forms.please_select')] + \GoProp\Models\ExtendedProfile::getPropertyLetLabel(), null, ['class' => 'form-control', 'id' => 'extended_profile_property_let']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <hr class="form-divider" />
            </div>
        </div>
        <div class="row">
            <div class="form-group clearfix">
                <div class="col-sm-2 col-xs-4">
                    <div id="userform-pic">
                        @if(empty(\Illuminate\Support\Facades\Auth::user()->profile->profile_picture))
                            <img src="{{ asset('assets/frontend/images/profile_pic_default.jpg') }}" class="img-responsive">
                        @else
                            <img src="{{ url('images/profile_picture/'.\Illuminate\Support\Facades\Auth::user()->profile->profile_picture) }}" class="img-responsive img-rounded">
                        @endif
                    </div>
                </div>
                <div class="col-sm-10 col-xs-8">
                    <header class="entry-header">
                        <h4 class="entry-title">{{ trans('forms.fields.profile_picture') }} <span class="text-muted">({{ trans('forms.optional') }})</span></h4>
                    </header>
                    <div class="entry-content">
                        <p>{{ trans('forms.fields.profile_picture_note') }}</p>
                        <p>&nbsp;</p>
                    </div>
                    <div class="btn btn-yellow file-input-button">
                        <span>{{ trans('forms.fields.profile_picture_button') }}</span>
                        {!! Form::file('profile[profile_picture]', ['id' => 'inputProfilePic']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group clearfix">
                <div class="col-xs-12">
                    {!! Form::label('extended_profile_referral_source', trans('extended_profile.referral_source_label')) !!} <sup class="text-danger">*</sup>
                </div>
                <div class="col-md-4">
                    {!! Form::select('profile[extendedProfile][referral_source]', ['' => trans('forms.please_select')] + \GoProp\Models\ExtendedProfile::getReferralSourceLabel(), null, ['class' => 'form-control', 'id' => 'extended_profile_referral_source']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <hr class="form-divider" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                @foreach($subscriptions as $subscription)
                    <div class="form-group clearfix">
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('subscriptions[]', $subscription->slug, in_array($subscription->slug, $model->subscriptions->pluck('slug')->all()), ['id' => $subscription->slug, 'class' => 'form-checkbox']) !!}
                                {!! Form::label($subscription->slug, trans('account.register.subscriptions.'.$subscription->slug)) !!}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <hr class="form-divider" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button class="btn btn-yellow">{{ trans('account.profile.update_btn') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection