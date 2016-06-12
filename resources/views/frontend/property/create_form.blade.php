<div class="row">
    <div class="col-sm-6">
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('property_name', trans('forms.fields.property.property_name')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::text('property_name', null, ['class' => 'form-control', 'placeholder' => trans('forms.fields.property.property_name_placeholder'), 'id' => 'property_name']) !!}
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('address', trans('forms.fields.address')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::textarea('address', null, ['rows' => 3, 'class' => 'form-control', 'id' => 'address']) !!}
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('postal_code', trans('forms.fields.postal_code')) !!}
            </div>
            <div class="col-xs-12">
                {!! Form::text('postal_code', null, ['class' => 'form-control', 'id' => 'postal_code']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('province', trans('forms.fields.province')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::select('province', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getProvinces(true), null, ['class' => 'form-control form-address-selector-province', 'id' => 'province']) !!}
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('city', trans('forms.fields.city')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::select('city', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getCities(old('province', $model->province), true), null, ['class' => 'form-control form-address-selector-city', 'id' => 'city']) !!}
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('subdistrict', trans('forms.fields.subdistrict')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::select('subdistrict', ['' => trans('forms.please_select')] + \GoProp\Facades\AddressHelper::getSubdistricts(old('city', $model->city), true), null, ['class' => 'form-control form-address-selector-subdistrict', 'id' => 'subdistrict']) !!}
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12">
    <hr class="form-divider" />
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('property_type', trans('forms.fields.property.property_type')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::select('property_type_id', ['' => trans('forms.please_select')] + \GoProp\Models\PropertyType::getOptions(), null, ['class' => 'form-control', 'id' => 'property_type']) !!}
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('rooms', trans('forms.fields.property.bedrooms')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::select('rooms', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getBedroomsLabel(), null, ['class' => 'form-control', 'id' => 'bedrooms']) !!}
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('bathrooms', trans('forms.fields.property.bathrooms')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::select('bathrooms', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getBathroomsLabel(), null, ['class' => 'form-control', 'id' => 'bathrooms']) !!}
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('maid_rooms', trans('forms.fields.property.maid_bedrooms')) !!}
            </div>
            <div class="col-xs-12">
                {!! Form::select('maid_rooms', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getMaidBedroomsLabel(), null, ['class' => 'form-control', 'id' => 'maid_rooms']) !!}
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('maid_bathrooms', trans('forms.fields.property.maid_bathrooms')) !!}
            </div>
            <div class="col-xs-12">
                {!! Form::select('maid_bathrooms', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getMaidBathroomsLabel(), null, ['class' => 'form-control', 'id' => 'maid_bathrooms']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('furnishing', trans('forms.fields.property.furnishing')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::select('furnishing', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getFurnishingLabel(), null, ['class' => 'form-control', 'id' => 'furnishing']) !!}
            </div>
        </div>

        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('carport_size', trans('forms.fields.property.carport_size')) !!}
            </div>
            <div class="col-xs-12">
                {!! Form::select('carport_size', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getCarsLabel(), null, ['class' => 'form-control', 'id' => 'garage_size']) !!}
            </div>
        </div>

        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('garage_size', trans('forms.fields.property.garage_size')) !!}
            </div>
            <div class="col-xs-12">
                {!! Form::select('garage_size', ['' => trans('forms.please_select')] + \GoProp\Models\Property::getCarsLabel(), null, ['class' => 'form-control', 'id' => 'garage_size']) !!}
            </div>
        </div>

        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('short_note', trans('forms.fields.property.short_note')) !!}
            </div>
            <div class="col-xs-12">
                {!! Form::textarea('short_note', null, ['class' => 'form-control', 'rows' => '2', 'id' => 'short_note']) !!}
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12">
    <header class="header-area">
        <h3 class="entry-title">{{ trans('property.create.list_detail_section_title') }} <sup class="text-danger">*</sup></h3>
    </header>
    <div class="entry-content">
        <p>{{ trans('property.create.list_detail_section_copy') }}</p>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('for_sell', trans('forms.fields.property.are_you_selling')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::select('for_sell', ['' => trans('forms.please_select')] + \GoProp\Facades\ProjectHelper::getYesNoOptions(), null, ['class' => 'form-control', 'id' => 'for_sell']) !!}
            </div>
        </div>
        <div data-field-dependent="for_sell|1" class="form-group clearfix">
            <div class="col-xs-12">
                <div>{{ trans('forms.fields.property.viewing_schedule') }} <sup class="text-danger">*</sup></div>
                @foreach(\GoProp\Models\Property::getViewingScheduleOptionLabel() as $viewingOptionIdx => $viewingOption)
                    <label class="checkbox-inline">
                        {!! Form::checkbox('sell_viewing_schedule[]', $viewingOptionIdx, (strpos($model->sell_viewing_schedule, $viewingOptionIdx) !== false)) !!} {{ $viewingOption }}
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div data-field-dependent="for_sell|1" class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('sell_price', trans('forms.fields.property.sell_price')) !!}
            </div>
            <div class="col-xs-12">
                {!! Form::text('sell_price', null, ['class' => 'form-control', 'id' => 'sell_price', 'data-inputmask' => '\'alias\': \'decimal\', \'groupSeparator\': \',\', \'autoGroup\': true, \'autoUnmask\': true, \'removeMaskOnSubmit\': true, \'rightAlign\': false']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <p>&nbsp;</p>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('for_rent', trans('forms.fields.property.are_you_renting')) !!} <sup class="text-danger">*</sup>
            </div>
            <div class="col-xs-12">
                {!! Form::select('for_rent', ['' => trans('forms.please_select')] + \GoProp\Facades\ProjectHelper::getYesNoOptions(), null, ['class' => 'form-control', 'id' => 'for_rent']) !!}
            </div>
        </div>
        <div data-field-dependent="for_rent|1" class="form-group clearfix">
            <div class="col-xs-12">
                <div>{{ trans('forms.fields.property.viewing_schedule') }} <sup class="text-danger">*</sup></div>
                @foreach(\GoProp\Models\Property::getViewingScheduleOptionLabel() as $viewingOptionIdx => $viewingOption)
                    <label class="checkbox-inline">
                        {!! Form::checkbox('rent_viewing_schedule[]', $viewingOptionIdx, (strpos($model->rent_viewing_schedule, $viewingOptionIdx) !== false)) !!} {{ $viewingOption }}
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div data-field-dependent="for_rent|1" class="form-group clearfix">
            <div class="col-xs-12">
                {!! Form::label('rent_price', trans('forms.fields.property.rent_price')) !!}
            </div>
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-8">
                        {!! Form::text('rent_price', null, ['class' => 'form-control', 'id' => 'rent_price', 'data-inputmask' => '\'alias\': \'decimal\', \'groupSeparator\': \',\', \'autoGroup\': true, \'autoUnmask\': true, \'removeMaskOnSubmit\': true, \'rightAlign\': false']) !!}
                    </div>
                    <div class="col-xs-4">
                        {!! Form::select('rent_price_type', \GoProp\Models\Property::getRentTypeLabel(), null, ['class' => 'form-control', 'id' => 'rent_price_type']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <p>&nbsp;</p>

        <div class="form-group">
            <div class="col-xs-6">
                {!! Form::button(trans('forms.save_information_btn'), ['name' => 'action', 'value' => 'save_information', 'type' => 'submit', 'class' => 'btn btn-yellow']) !!}
            </div>
            <div class="col-xs-6 text-right">
                {!! Form::button(trans('forms.save_continue_btn'), ['name' => 'action', 'value' => 'save_continue', 'type' => 'submit', 'class' => 'btn btn-yellow']) !!}
            </div>
        </div>
    </div>
</div>

@section('bottom_scripts')
    @parent

    {!! $validator->selector('#property-form') !!}
@stop