@extends('frontend.master.layout_with_slider')

@section('page_title', ProjectHelper::formatTitle($content->title))

@section('content')
    <section class="contactform-columns">
        <div class="container">
            <div class="col-sm-8">
                <div class="contact-form-area">
                    <div class="entry-header text-center">
                        <div class="entry-icon"><span><i class="fa fa-comments-o"></i></span></div>
                        <h3 class="entry-title">
                            {!! trans('contact.contact_form_title') !!}
                        </h3>
                    </div>
                    <div class="entry-content">
                        @include('frontend.master.messages')

                        {!! Form::open() !!}
                        <div class="form-group">
                            {!! Form::label('fullname', trans('contact.form.fullname')) !!} <sup class="text-danger">*</sup>
                            {!! Form::text('fullname', null, ['class' => 'form-control', 'id' => 'fullname']) !!}
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
                            {!! Form::label('subject', trans('contact.form.subject')) !!}
                            {!! Form::text('subject', null, ['class' => 'form-control', 'id' => 'subject']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('message', trans('contact.form.message')) !!} <sup class="text-danger">*</sup>
                            {!! Form::textarea('message', null, ['rows' => 8, 'class' => 'form-control', 'id' => 'message']) !!}
                        </div>
                            <div class="form-group form-submit">
                                {!! Form::submit(trans('contact.form.send_btn'), ['class' => 'btn btn-yellow']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-4 contact-side">
                @if($content)
                    {!! $content->content !!}
                @endif
            </div>
        </div>
    </section>
@stop