@extends('frontend.master.layout')

@section('page_title', ProjectHelper::formatTitle(!empty($content->meta_title)?$content->meta_title:$content->title))

@section('meta_description', !empty($content->meta_description)?$content->meta_description:str_limit(trim(preg_replace('/\s\s+/', ' ', strip_tags($content->content))), 150))

@section('open_graph')
    @parent

    <meta property="og:url" content="{{ route('frontend.page.referral_listing') }}" />
    <meta property="og:title" content="{{ ProjectHelper::formatTitle($content->title) }}" />
    <meta property="og:description" content="Pendapat bahwa “ tidak ada lagi yang gampang di dunia ini”, belum tentu benar. Jika anda seorang profesional muda yang smart, senang networking, dan ingin maju, dunia properti bisa jadi kunci income tambahan anda." />
    <meta property="og:image" content="{{ asset('assets/frontend/images/referral_poster.jpg') }}" />
    <meta property="og:image:width" content="480" />
    <meta property="og:image:height" content="480" />
@stop

@section('content')
    <section class="post-columns">
        {!! $content->content !!}
        <p>&nbsp;</p>

        <div class="container">
            <div class="col-md-3">&nbsp;</div>

            <div class="col-md-6">
                {!! Form::open(['id' => 'referral-listing-form']) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('contact.form.fullname')) !!} <sup class="text-danger">*</sup>
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'fullname']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', trans('contact.form.email')) !!} <sup class="text-danger">*</sup>
                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('contact_number', trans('contact.form.contact_number')) !!} <sup class="text-danger">*</sup>
                    {!! Form::text('contact_number', null, ['class' => 'form-control', 'id' => 'contact_number']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('address', trans('contact.form.address')) !!} <sup class="text-danger">*</sup>
                    {!! Form::text('address', null, ['class' => 'form-control', 'id' => 'address']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('province', trans('contact.form.province')) !!} <sup class="text-danger">*</sup>
                    {!! Form::select('province', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getProvinces(true), null, ['class' => 'form-control form-address-selector-province', 'id' => 'province']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('city', trans('contact.form.city')) !!} <sup class="text-danger">*</sup>
                    {!! Form::select('city', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getCities(old('province'), true), null, ['class' => 'form-control form-address-selector-city', 'id' => 'city']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('subdistrict', trans('contact.form.subdistrict')) !!} <sup class="text-danger">*</sup>
                    {!! Form::select('subdistrict', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getSubdistricts(old('city'), true), null, ['class' => 'form-control form-address-selector-subdistrict', 'id' => 'subdistrict']) !!}
                </div>
                <div class="form-group form-submit text-center">
                    {!! Form::submit(trans('contact.form.register_btn'), ['class' => 'btn btn-yellow']) !!}
                </div>
                {!! Form::close() !!}
            </div>

            <div class="col-md-3">&nbsp;</div>
        </div>
    </section>
@stop

@section('bottom_scripts')
    @parent

    {!! $validator->selector('#referral-listing-form') !!}
@stop