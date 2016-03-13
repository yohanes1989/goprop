<div class="login-form-widget">
    <h4 class="entry-title">{{ trans('property.advanced_search_widget.advanced_search') }}</h4>
    <div class="advanced-search-wrapper login-form-wrapper">
        <div class="col-xs-12">
            {!! Form::open(['method' => 'GET', 'route' => 'frontend.property.search']) !!}
                <div class="form-group">
                    {!! Form::select('search[for]', ['' => trans('forms.fields.all')] + \GoProp\Models\Property::getForLabel(), [\Illuminate\Support\Facades\Request::input('search.for')], ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('search[keyword]',  null, ['class' => 'form-control', 'placeholder' => trans('forms.fields.keyword'), 'id' => 'keyword']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('search[province]', ['' => trans('forms.fields.all_provinces')] + \GoProp\Facades\AddressHelper::getProvinces(true), [\Illuminate\Support\Facades\Request::input('search.province')], ['data-default-label' => trans('forms.fields.all_cities'), 'class' => 'form-control form-address-selector-province', 'id' => 'province']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('search[city]', ['' => trans('forms.fields.all_cities')] + \GoProp\Facades\AddressHelper::getCities(\Illuminate\Support\Facades\Request::input('search.province'), true), [\Illuminate\Support\Facades\Request::get('city')], ['data-default-label' => trans('forms.fields.all_areas'), 'class' => 'form-control form-address-selector-city', 'id' => 'city']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('search[subdistrict]', ['' => trans('forms.fields.all_areas')] + \GoProp\Facades\AddressHelper::getSubdistricts(\Illuminate\Support\Facades\Request::input('search.city'), true), [\Illuminate\Support\Facades\Request::get('subdistrict')], ['class' => 'form-control form-address-selector-subdistrict', 'id' => 'subdistrict']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('search[type]', ['' => trans('forms.fields.all_types')] + \GoProp\Models\PropertyType::getOptions(), [\Illuminate\Support\Facades\Request::input('search.type')], ['class' => 'form-control', 'id' => 'property_type']) !!}
                </div>
                <div class="form-group">
                    {!! Form::select('search[rooms]', ['' => trans('forms.fields.min_rooms')] + \GoProp\Models\Property::getBedroomsLabel(), \Illuminate\Support\Facades\Request::input('search.room', null), ['class' => 'form-control', 'id' => 'rooms']) !!}
                </div>
                <div class="form-group">
                    <div>{{ trans('property.index.price_range') }}: <strong>IDR <span id="price-from">100000000</span> - IDR <span id="price-to">100000000000</span></strong></div>
                    <input type="text" id="inputPriceRange" name="search[price]" value="" data-min="100000000" data-max="100000000000"
                           data-step="50000000" data-from="100000000" data-to="100000000000" />
                </div>
                <div class="form-group">
                    <button class="btn btn-yellow btn-shadow btn-submit">{{ trans('property.index.search_property') }}</button>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="clearfix"></div>
    </div>
</div>