@extends('frontend.master.layout')

@section('page_title', ProjectHelper::formatTitle($content->title))

@section('content')
    <section class="post-columns">
        {!! $content->content !!}
        <p>&nbsp;</p>

        <div class="row">
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
                    {!! Form::label('city', trans('contact.form.city')) !!} <sup class="text-danger">*</sup>
                    {!! Form::text('city', null, ['class' => 'form-control', 'id' => 'city']) !!}
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