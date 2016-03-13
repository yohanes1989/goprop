@extends('frontend.account.logged_in.layout')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <header class="header-area">
                <h3 class="entry-title">{{ trans('property.create.page_title') }}</h3>
            </header>
            <div class="entry-content">
                <p>{{ trans('property.create.body_copy') }} <sup class="text-danger">*</sup> {{ trans('forms.required_fields') }}</p>
            </div>
            <div class="row">
                <div class="register-form-wrapper">
                    {!! Form::model($model, ['route' => ['frontend.property.edit.process', 'id' => $model->id], 'id' => 'property-form']) !!}
                    @include('frontend.property.create_form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection