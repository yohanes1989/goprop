<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('name', 'Owner Name *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('name', null, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>'Full Name')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('contact_number', 'Contact Number *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('contact_number', null, array('class'=>'form-control', 'id' => 'contact_number', 'placeholder'=>'Contact Number')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('other_contact_number', 'Other Contact Number', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('other_contact_number', null, array('class'=>'form-control', 'id' => 'other_contact_number', 'placeholder'=>'Other Contact Number')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::email('email', null, array('class'=>'form-control', 'id' => 'email', 'placeholder'=>'Email Address')) !!}
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('property_type', 'Property Type *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('property_type_id', ['' => trans('forms.please_select')] + \GoProp\Models\PropertyType::getOptions(), null, ['class' => 'form-control select-chosen', 'id' => 'property_type']) !!}
        </div>
    </div>

   <div class="form-group">
        {!! Form::label('address', 'Address *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::textarea('address', null, array('class'=>'form-control', 'id' => 'address', 'rows' => 3)) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('location', 'Location *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('province', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getProvinces(true), null, ['class' => 'form-control form-address-selector-province', 'id' => 'province']) !!}
            <div style="height: 10px;"></div>
            {!! Form::select('city', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getCities(old('province', $referralInformation->province), true), null, ['class' => 'form-control form-address-selector-city', 'id' => 'city']) !!}
            <div style="height: 10px;"></div>
            {!! Form::select('subdistrict', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getSubdistricts(old('city', $referralInformation->city), true), null, ['class' => 'form-control form-address-selector-subdistrict', 'id' => 'subdistrict']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('postal_code', 'Postal Code', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('postal_code', null, array('class'=>'form-control', 'id' => 'postal_code' ,'placeholder'=>'Postal Code')) !!}
        </div>
    </div>
</div>

@if($isAdmin)
<hr/>

<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('status', 'Status', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('status', ['' => trans('forms.please_select')] + \GoProp\Models\ReferralInformation::getStatusOptions(), null, ['class' => 'form-control select-chosen', 'id' => 'status']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-4"></div>
        <div class="col-md-8"><label>{!! Form::checkbox('followed_up', 1, null) !!} Has been Followed Up</label></div>
    </div>
</div>
@endif

<div class="form-group">
    <div class="col-md-12 text-center">
        {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
        {!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}

        <a href="{{ route('admin.referrals.index') }}" class="btn btn-warning">Cancel</a>
    </div>
</div>

@if(!$isAdmin)
<p class="well">
    If you have any questions, please feel free to contact us at <a href="tel:{{ config('app.contact_number') }}">{{ config('app.contact_number') }}</a> or <a href="mailto:marketing@goprop.co.id">marketing@goprop.co.id</a>.<br/>
    <strong>We will answer and reply at Office Hours.</strong>
</p>
@endif