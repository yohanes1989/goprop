@extends('frontend.account.logged_in.layout')

@section('content')
    <div class="top-navigation">
        <div class="row">
            <div class="col-md-10">
                @include('frontend.property.includes.edit_top_bar')
                <div class="form-wizard-menu">
                    <ul class="list-unstyled">
                        <li class="active"><a href="{{ route('frontend.property.edit', ['id' => $model->id]) }}">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.main_details') }}</span>
                            </a></li>
                        <li class="active"><a href="{{ route('frontend.property.details', ['id' => $model->id]) }}">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.property_details') }}</span>
                            </a></li>
                        <li class="active"><a href="{{ route('frontend.property.map', ['id' => $model->id]) }}">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.map') }}</span>
                            </a></li>
                        <li class="active"><a href="{{ route('frontend.property.photos', ['id' => $model->id]) }}">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.photos') }}</span>
                            </a></li>
                        <li class="active"><a href="{{ route('frontend.property.floorplans', ['id' => $model->id]) }}">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.floorplan') }}</span>
                            </a></li>
                        <li class="current"><a href="">
                                <div class="img-wrap"></div>
                                <span>{{ trans('property.steps.packages') }}</span>
                            </a></li>
                    </ul>
                    <div class="form-wizard-progressbar">
                        <div class="form-wizard-bars" style="width: 90%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <div class="register-form-wrapper">
                {!! Form::model($model, ['route' => ['frontend.property.review.process', 'id' => $model->id]]) !!}
                <header class="header-area">
                    <h3 class="entry-title">{!! trans('property.order_review.page_title') !!}</h3>
                </header>
                <div class="entry-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                {!! Form::label('property_name', trans('forms.fields.property.property_name')) !!}:
                                <div>{{ $model->property_name }}</div>
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('address', trans('forms.fields.address')) !!}:
                                <div>{{ $model->address }}</div>
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('postal_code', trans('forms.fields.postal_code')) !!}: {{ $model->postal_code }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                {!! Form::label('province', trans('forms.fields.province')) !!}: {{ \GoProp\Facades\AddressHelper::getAddressLabel($model->province, 'province') }}
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('city', trans('forms.fields.city')) !!}: {{ \GoProp\Facades\AddressHelper::getAddressLabel($model->city, 'city') }}
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('subdistrict', trans('forms.fields.subdistrict')) !!}: {{ \GoProp\Facades\AddressHelper::getAddressLabel($model->subdistrict, 'subdistrict') }}
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                {!! Form::label('property_type', trans('forms.fields.property.property_type')) !!}: {{ trans('property.property_type.'.$model->type->slug) }}
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('rooms', trans('forms.fields.property.bedrooms')) !!}: {{ $model->rooms }}
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('bathrooms', trans('forms.fields.property.bathrooms')) !!}: {{ $model->bathrooms }}
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('maid_rooms', trans('forms.fields.property.maid_bedrooms')) !!}: {{ $model->maid_rooms }}
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('maid_bathrooms', trans('forms.fields.property.maid_bathrooms')) !!}: {{ $model->maid_bathrooms }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                {!! Form::label('furnishing', trans('forms.fields.property.furnishing')) !!}: {{ \GoProp\Models\Property::getFurnishingLabel($model->furnishing) }}
                            </div>

                            <div class="form-group clearfix">
                                {!! Form::label('carport_size', trans('forms.fields.property.carport_size')) !!}: {{ $model->carport_size }}
                            </div>

                            <div class="form-group clearfix">
                                {!! Form::label('garage_size', trans('forms.fields.property.garage_size')) !!}: {{ $model->garage_size }}
                            </div>

                            <div class="form-group clearfix">
                                {!! Form::label('short_note', trans('forms.fields.property.short_note')) !!}:
                                <div>{!! $model->short_note?nl2br($model->short_note):'-' !!}</div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                {!! Form::label('building_size', trans('forms.fields.property.building_size')) !!}: {!! intval($model->building_size)?($model->building_size+0).' m<sup>2</sup>':'-' !!}
                            </div>

                            <div class="form-group clearfix">
                                {!! Form::label('building_dimension', trans('forms.fields.property.building_dimension')) !!}: {{ $model->buildingDimension?$model->buildingDimensionWithUnit:'-' }}
                            </div>

                            <div class="form-group clearfix">
                                {!! Form::label('land_size', trans('forms.fields.property.land_size')) !!}: {!! intval($model->land_size)?($model->land_size+0).' m<sup>2</sup>':'-' !!}
                            </div>

                            <div class="form-group clearfix">
                                {!! Form::label('land_dimension', trans('forms.fields.property.land_dimension')) !!}: {{ $model->landDimensionWithUnit }}
                            </div>

                            <div class="form-group clearfix">
                                {!! Form::label('certificate', trans('forms.fields.property.certificate')) !!}: {{ $model->certificate?\GoProp\Models\Property::getCertificateLabel($model->certificate):'-' }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                {!! Form::label('floors', trans('forms.fields.property.floors')) !!}: {{ $model->floors+0 }}
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('phone_lines', trans('forms.fields.property.phone_lines')) !!}: {{ $model->phone_lines }}
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('electricity', trans('forms.fields.property.electricity')) !!}: {{ $model->electricity?trans('forms.fields.property.watt', ['electricity' => $model->electricity]):'-' }}
                            </div>
                            <div class="form-group clearfix">
                                {!! Form::label('orientation', trans('forms.fields.property.orientation')) !!}: {{ $model->orientation?\GoProp\Models\Property::getOrientationLabel($model->orientation):'-' }}
                            </div>
                        </div>
                        <div class="col-sm-12">
                            {!! Form::label('description', trans('forms.fields.property.description')) !!}:
                            <p>{!! $model->description?nl2br($model->description):'-' !!}</p>
                        </div>
                    </div>
                </div>

                <header class="header-area">
                    <h4 class="entry-title">{!! trans('property.order_review.your_package') !!}</h4>
                </header>
                <div class="entry-content">
                    <p>
                        @foreach($model->packages as $package)
                            {{ trans('property.package.category.'.$package->category->slug.'_label').': '.$package->name }}<br/>
                        @endforeach
                    </p>
                </div>

                <?php $addons = $order->getAddons(); ?>
                @if(count($addons) > 0)
                <header class="header-area">
                    <h4 class="entry-title">{!! trans('property.order_review.addons') !!}</h4>
                </header>
                <div class="entry-content">
                    <ul class="list-unstyled">
                        @foreach($addons as $addon)
                        <li>{{ trans('property.package.feature.'.$addon->code) }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($order->total_amount > 0)
                <header class="header-area">
                    <h4 class="entry-title">{!! trans('property.order_review.payment_methods') !!}</h4>
                </header>
                <div class="entry-content" id="payment-method-section">
                    <div class="row">
                        <div class="col-sm-4 col-xs-6">
                            @foreach(\GoProp\Models\Payment::getPaymentMethods() as $paymentMethodIdx=>$paymentMethod)
                            <div class="radio">
                                <label>
                                    {!! Form::radio('payment_method', $paymentMethodIdx, (old('payment_method') == $paymentMethodIdx)) !!} {{ $paymentMethod['label'] }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="col-sm-8 col-xs-6">
                            <div id="payment-descriptions">
                                @foreach(\GoProp\Models\Payment::getPaymentMethods() as $paymentMethodIdx=>$paymentMethod)
                                <div data-payment_method="{{ $paymentMethodIdx }}" class="payment-description">
                                    <p>
                                        {!! $paymentMethod['description'] !!}
                                    </p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    {!! Form::hidden('payment_method', \GoProp\Models\Payment::METHOD_NO_PAYMENT) !!}
                @endif

                <header class="header-area">
                    <h4 class="entry-title">{!! trans('property.order_review.total_cost') !!}</h4>
                </header>

                <div class="entry-content">
                    {{ trans('property.order_review.agent_commission') }}: {{ \GoProp\Facades\ProjectHelper::formatNumber($order->package->getCommission($model->getPrice($model->getViewFor())), TRUE) }}
                    <br/>
                    {{ trans('property.order_review.upfront_fee') }}: {{ \GoProp\Facades\ProjectHelper::formatNumber($order->total_amount, TRUE) }}
                </div>

                <div class="entry-content">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('agree_tc', 1, false) !!}
                            {{ trans('property.order_review.agree_tc') }} <a href="{{ route('frontend.page.static_page', ['identifier' => 'property-terms-conditions']) }}" class="ajax_popup fancybox.ajax">{{ trans('property.order_review.terms_conditions') }}</a>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6 payment"><img src="{{ asset('assets/frontend/images/payment-logo.png') }}" class="img-responsive"></div>
                </div>
                <div class="row">
                    <hr class="form-divider">
                </div>
                <div class="form-action row">
                    <div class="col-xs-6 is-left">
                        {!! Form::button(trans('forms.change_package_btn'), ['name' => 'action', 'value' => 'change_package', 'type' => 'submit', 'class' => 'btn btn-transparent']) !!}
                    </div>
                    <div class="col-xs-6 is-right">
                        {!! Form::button(trans('forms.submit_btn'), ['name' => 'action', 'value' => 'purchase', 'data-confirm' => trans('property.order_review.confirm_message'), 'type' => 'submit', 'class' => 'btn btn-grey']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('bottom_scripts')
    @parent

    <script>
        $('.radio input[name="payment_method"]', '#payment-method-section').on('click', function(){
            $('.payment-description', '#payment-descriptions').hide();
            $('.payment-description[data-payment_method="'+$(this).val()+'"]', '#payment-descriptions').show();
        });

        if($('.radio input[name="payment_method"]:checked', '#payment-method-section').length > 0){
            $('.radio input[name="payment_method"]:checked', '#payment-method-section').click();
        }else{
            $('.radio:first-child input[name="payment_method"]', '#payment-method-section').click();
        }
    </script>
@endsection