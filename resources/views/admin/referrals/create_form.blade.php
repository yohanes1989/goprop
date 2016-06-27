<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('name', 'Nama Pemilik *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('name', null, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>'Full Name')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('contact_number', 'Nomor Telpon *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::text('contact_number', null, array('class'=>'form-control', 'id' => 'contact_number', 'placeholder'=>'Contact Number')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('other_contact_number', 'Nomor Telpon lain', array('class'=>'col-md-4 control-label')) !!}
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
        {!! Form::label('property_type', 'Tipe Properti *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('property_type_id', ['' => trans('forms.please_select')] + \GoProp\Models\PropertyType::getOptions(), null, ['class' => 'form-control select-chosen', 'id' => 'property_type']) !!}
        </div>
    </div>

   <div class="form-group">
        {!! Form::label('address', 'Alamat *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::textarea('address', null, array('class'=>'form-control', 'id' => 'address', 'rows' => 3)) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('location', 'Lokasi *', array('class'=>'col-md-4 control-label')) !!}
        <div class="col-md-8">
            {!! Form::select('province', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getProvinces(true), null, ['class' => 'form-control form-address-selector-province', 'id' => 'province']) !!}
            <div style="height: 10px;"></div>
            {!! Form::select('city', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getCities(old('province', $referralInformation->province), true), null, ['class' => 'form-control form-address-selector-city', 'id' => 'city']) !!}
            <div style="height: 10px;"></div>
            {!! Form::select('subdistrict', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getSubdistricts(old('city', $referralInformation->city), true), null, ['class' => 'form-control form-address-selector-subdistrict', 'id' => 'subdistrict']) !!}
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

<div class="clearfix"></div>

<hr/>

<div class="col-md-12">
    @if(!$isAdmin)
        <div class="form-group text-center">
            <div class="col-md-12"><label>{!! Form::checkbox('owner_notified', 1, null) !!} Saya sudah memperkenalkan GoProp dan Owner telah bersedia untuk dihubungi.</label></div>
        </div>
    @endif

    <div class="form-group">
        <div class="text-center">
            {!! Form::submit('Submit',array('class'=>'btn btn-primary')) !!}

            <a href="{{ route('admin.referrals.index') }}" class="btn btn-default">Cancel</a>
        </div>
    </div>
</div>

<div class="clearfix"></div>