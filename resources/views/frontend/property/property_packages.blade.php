@extends('frontend.account.logged_in.layout')

@section('bottom_scripts')
    <script>
        var CommissionRules = function CommissionRules(){
            @foreach($packageCategories as $idx=>$packageCategory)
                @foreach($packageCategory->packages as $package)
                    this.package_{{ $package->id }} = {!! json_encode(unserialize($package->commission)) !!};
                @endforeach
            @endforeach
        };

        commissionRules = new CommissionRules();
    </script>

    @parent
@endsection

@section('content')
    <div class="top-navigation">
        <div class="row">
            <div class="col-sm-10">
                <div class="menu-preview">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('frontend.property.view', ['for' => $model->getViewFor(), 'id' => $model->id, 'preview' => TRUE, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}"><img src="{{ asset('assets/frontend/images/property-preview.png') }}" alt="" /> {{ trans('property.create.preview_property') }}</a></li>
                        <li><a href="#"><img src="{{ asset('assets/frontend/images/property-disable.png') }}" alt="" /> Disable property</a></li>
                    </ul>
                </div>
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
            <div class="col-sm-2"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10">
            <header class="header-area">
                <h3 class="entry-title">{!! trans('property.packages.page_title', ['title' => $model->property_name]) !!}</h3>
            </header>
            <div class="row">
                <div class="col-xs-12">
                    <div class="entry-content">
                        <p>{{ trans('property.packages.body_copy') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="register-form-wrapper">
                    {!! Form::model($model, ['route' => ['frontend.property.packages.process', 'id' => $model->id]]) !!}
                    <div class="property-table-columns col-xs-12">
                        <!-- Custom Tabs -->
                        <div class="custom-tabs">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs text-right" role="tablist">
                                <li role="presentation" class="active"><a href="#sell-property" aria-controls="sell-property" role="tab" data-toggle="tab">Sell My Property</a></li>
                                <li role="presentation"><a href="#rent-property" aria-controls="rent-property" role="tab" data-toggle="tab">Rent My Property</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                @foreach($packageCategories as $idx=>$packageCategory)
                                    <?php $mostPackage = $packageCategory->getPackageWithMostFeatures(); ?>
                                <div role="tabpanel" class="tab-pane {{ $idx==0?'active':'' }}" id="{{ $packageCategory->slug }}-property">
                                    <header class="entry-header text-center">
                                        <h3 class="entry-title">{{ trans('property.package.category.'.$packageCategory->slug) }}</h3>
                                    </header>
                                    <div class="entry-content">
                                        <table class="table table-custom packages-table">
                                            <thead>
                                            <tr>
                                                <th width="34%">&nbsp;</th>
                                                @foreach($packageCategory->packages as $package)
                                                <th width="22%" class="colored {{ $package->css_class }}">{{ $package->name }}</th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    {{ trans('property.package.feature.'.$packageCategory->slug.'-fee') }}
                                                    <div class="note">
                                                        * {{ trans('property.package.feature.'.$packageCategory->slug.'-fee-notes') }}
                                                    </div>
                                                </td>
                                                @foreach($packageCategory->packages as $package)
                                                    <td class="colored {{ $package->css_class }}">{{ $package->fee_description }}</td>
                                                @endforeach
                                            </tr>
                                            @foreach($mostPackage->features as $feature)
                                            <tr>
                                                <td>{{ trans('property.package.feature.'.$feature->code) }}</td>
                                                @foreach($packageCategory->packages as $package)
                                                    <td class="colored {{ $package->css_class }}">
                                                        @if($feature->isPackageFeature($package))
                                                            <?php
                                                                $featurePrice = $package->getFeature($feature)->pivot->price;
                                                            ?>
                                                            @if(empty(round($featurePrice)))
                                                                <span class="icon icon-blue"><i class="fa fa-check-circle"></i></span>
                                                            @else
                                                                <div class="checkbox">
                                                                    <?php
                                                                        $selected = FALSE;
                                                                        if(isset($selectedAddons[$package->id])){
                                                                            $selected = in_array($feature->id, $selectedAddons[$package->id]);
                                                                        }
                                                                    ?>
                                                                    <label>
                                                                        {!! Form::checkbox('features['.$package->id.'][]', $feature->id, $selected, [
                                                                            'data-price' => $featurePrice,
                                                                            'data-package' => $package->id,
                                                                            'class' => 'feature-price'
                                                                        ]) !!}
                                                                        {{ \GoProp\Facades\ProjectHelper::formatNumber($featurePrice) }}
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <span class="icon icon-red"><i class="fa fa-times-circle"></i></span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                            <tr class="up-front-fee-row">
                                                <td>
                                                    {{ trans('property.package.feature.up-front-fees') }}
                                                </td>
                                                @foreach($packageCategory->packages as $package)
                                                    <td class="colored {{ $package->css_class }}">
                                                        <div data-package="{{ $package->id }}" class="text up-front-total"></div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td><strong>{{ trans('property.package.feature.value') }}</strong></td>
                                                @foreach($packageCategory->packages as $package)
                                                    <td>
                                                        <input type="text"  data-package="{{ $package->id }}" value="3000000000" class="property-price form-control text-center">
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('property.package.feature.projection-fee') }}*</strong></td>
                                                @foreach($packageCategory->packages as $package)
                                                    <td>
                                                        <div data-package="{{ $package->id }}" class="text projection-fee"></div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td><strong>{{ trans('property.package.feature.you-can-save') }}**</strong></td>
                                                @foreach($packageCategory->packages as $package)
                                                    <td>
                                                        <div data-package="{{ $package->id }}" class="text saving-amount"></div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td></td>
                                                @foreach($packageCategory->packages as $package)
                                                <td>
                                                    {!! Form::button(trans('property.package.submit_btn'), ['name' => 'action', 'type' => 'submit', 'class' => 'btn btn-yellow', 'value' => $package->id]) !!}
                                                </td>
                                                @endforeach
                                            </tr>
                                            </tfoot>
                                        </table>

                                        <div class="col-xs-12">
                                            <div class="row">
                                                <div class="notes col-sm-12">
                                                    <div><small>* {{ trans('property.package.min_fee') }}</small></div>
                                                    <div><small>** {{ trans('property.package.save_calculation') }}</small></div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-7"></div>
                                                <div class="payment col-sm-5">
                                                    <img src="{{ asset('assets/frontend/images/payment-logo.png') }}" class="img-responsive">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
@endsection