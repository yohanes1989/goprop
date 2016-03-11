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
            <div class="col-sm-2"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10">
            @if($model->status == \GoProp\Models\Property::STATUS_DRAFT)
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
                        <div id="package-selection-tabs" class="custom-tabs">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                @foreach($packageCategories as $idx=>$packageCategory)
                                    <?php $mostPackage = $packageCategory->getPackageWithMostFeatures(); ?>
                                    <div role="tabpanel" class="{{ $idx==count($packageCategories)-1?'last-tab-pane':'' }} tab-pane {{ $idx==0?'active':'' }}" id="{{ $packageCategory->slug }}-property">
                                        <header class="entry-header text-center">
                                            <h3 class="entry-title">{{ trans('property.package.'.$packageCategory->slug.'_package') }}</h3>
                                        </header>
                                        <div class="entry-content">
                                            <table class="table table-custom packages-table">
                                                <thead>
                                                <tr>
                                                    <th width="34%">&nbsp;</th>
                                                    @foreach($packageCategory->packages as $package)
                                                    <th width="22%" data-package="{{ $package->slug }}" class="colored {{ $package->css_class }}">{{ $package->name }}</th>
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
                                                        <td data-package="{{ $package->slug }}" class="colored {{ $package->css_class }}">
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
                                                                                'data-package-slug' => $package->slug,
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
                                                <!--
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
                                                -->
                                                <tr>
                                                    <td>
                                                        @if($idx!=0)
                                                        <a class="btn btn-bordered package-select-back" href="#"></a>
                                                        @endif
                                                    </td>
                                                    @foreach($packageCategory->packages as $package)
                                                    <td>
                                                        {!! Form::button(trans('property.package.submit_btn'), ['name' => 'package_select', 'type' => 'submit', 'data-package' => $package->slug, 'data-package-category' => $packageCategory->slug, 'class' => 'btn btn-yellow', 'value' => $package->id]) !!}
                                                    </td>
                                                    @endforeach
                                                </tr>
                                                </tfoot>
                                            </table>

                                            <div class="col-xs-12">
                                                <!--
                                                <div class="row">
                                                    <div class="notes col-sm-12">
                                                        <div><small>* {{ trans('property.package.min_fee') }}</small></div>
                                                        <div><small>** {{ trans('property.package.save_calculation') }}</small></div>
                                                    </div>
                                                </div>
                                                -->

                                                <div class="row">
                                                    <div class="col-sm-7"></div>
                                                    <div class="payment col-sm-5">
                                                        <img src="{{ asset('assets/frontend/images/payment-logo.png') }}" class="img-responsive">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        {!! Form::hidden('action[]', null, ['id' => $packageCategory->slug.'-action']) !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @else
                <header class="header-area">
                    <h3 class="entry-title">{!! trans('property.packages_edit.page_title', ['title' => $model->property_name]) !!}</h3>
                </header>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="entry-content">
                            @foreach($model->packages as $package)
                                <header class="header-area">
                                    <h4 class="entry-title">{{ trans('property.package.category.'.$package->category->slug.'_label').': '.$package->name }}</h4>
                                </header>

                                <?php $addons = explode('|', $package->pivot->addons); ?>
                                <ul class="list-unstyled">
                                    @foreach($addons as $addon)
                                        <?php $addon = \GoProp\Models\PackageFeature::findOrFail($addon); ?>
                                        <li>{{ trans('property.package.feature.'.$addon->code) }}</li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>

                        <div class="entry-content">
                            <p>{{ trans('property.packages_edit.body_copy') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-sm-2"></div>
    </div>
@endsection

@section('bottom_scripts')
    @parent

    <script type="text/javascript">
        function changeTab(dir){
            var $currentTab = $('#package-selection-tabs .tab-pane.active');

            $("html, body").animate({ scrollTop: $('#package-selection-tabs').offset().top-100 }, 600, function(){
                if(dir == 'next'){
                    $currentTab.removeClass('active').next('.tab-pane').addClass('active');
                }else{
                    $currentTab.removeClass('active').prev('.tab-pane').addClass('active');
                }
            });
        }

        $(function(){
            //Hide same addon row on other pane
            $('.feature-price', '#package-selection-tabs .tab-pane:eq(0)').each(function(idx, obj){
                $('.feature-price[value="'+$(obj).val()+'"]', '#package-selection-tabs .tab-pane:gt(0)').parents('tr').hide();
            });

            $('.package-select-back').each(function(idx, obj){
                $(obj).click(function(e){
                    e.preventDefault();

                    changeTab('prev');
                });

                $(obj).text($('#package-selection-tabs .tab-pane:eq('+idx+') .entry-header .entry-title').text());
            });

            $('#package-selection-tabs button[name="package_select"]').click(function(e){
                e.preventDefault();

                $('#'+$(this).data('package-category')+'-action').val($(this).val());

                if($(this).parents('.tab-pane').hasClass('last-tab-pane')){
                    $('#package-selection-tabs').parents('form').submit();
                }else{
                    $('td[data-package="'+$(this).data('package')+'"] .feature-price', '#package-selection-tabs .tab-pane.active').each(function(idx, obj){
                        var $siblings = $('.feature-price[value="'+$(obj).val()+'"]', $('#package-selection-tabs .tab-pane:not(.active)'));
                        $siblings.prop('checked', this.checked).change();
                    });

                    changeTab('next');
                }
            });
        });
    </script>
@stop