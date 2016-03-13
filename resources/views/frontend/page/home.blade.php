@extends('frontend.master.layout_with_slider')

@section('page_class', 'index-page')

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
    @if($serviceSection)
    <section class="service-columns">
        <div class="container">
            {!! $serviceSection->content !!}
        </div>
    </section>
    @endif

    @include('frontend.includes.call_request_home')

    @if($overviewSection)
        {!! $overviewSection->content !!}
    @endif

    <section id="packages" class="property-table-columns">
        <div class="container">
            <div class="col-xs-12">
                <header class="header-area text-center">
                    <h2 class="entry-title text-uppercase">{{ trans('general.home_packages.title') }}</h2>
                </header>
            </div>

            {!! Form::open(['route' => ['frontend.property.add_to_cart']]) !!}
            <div class="property-table-columns">
                <!-- Custom Tabs -->
                <div class="custom-tabs">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs text-right" role="tablist">
                        <li role="presentation" class="active"><a href="#sell-property" aria-controls="sell-property" role="tab" data-toggle="tab">{{ trans('property.package.category.sell') }}</a></li>
                        <li role="presentation"><a href="#rent-property" aria-controls="rent-property" role="tab" data-toggle="tab">{{ trans('property.package.category.rent') }}</a></li>
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
                                                    {{ trans('property.package.feature.'.$packageCategory->slug.'-fee-notes') }}
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
                                                    <input type="text"  data-package="{{ $package->id }}" value="" placeholder="{{ trans('forms.input_price') }}" class="property-price form-control text-center">
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
                                        @if($packageCategory->slug != 'rent')
                                            <tr>
                                                <td><strong>{{ trans('property.package.feature.you-can-save') }}**</strong></td>
                                                @foreach($packageCategory->packages as $package)
                                                    <td>
                                                        <div data-package="{{ $package->id }}" class="text saving-amount"></div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endif
                                        <tr>
                                            <td></td>
                                            @foreach($packageCategory->packages as $package)
                                                <td>
                                                    {!! Form::button(trans('forms.sign_up_btn'), ['name' => 'action', 'type' => 'submit', 'class' => 'btn btn-yellow', 'value' => $package->id]) !!}
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

                                        @if($packageCategory->slug != 'rent')
                                            <div class="row">
                                                <div class="col-sm-7"></div>
                                                <div class="payment col-sm-5">
                                                    <img src="{{ asset('assets/frontend/images/payment-logo.png') }}" class="img-responsive">
                                                </div>
                                            </div>
                                        @endif
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
    </section><!-- end of property-table-columns -->

    @include('frontend.includes.price_saving_home')

    @if($testimonials->count() > 0)
    <section class="testimonial-columns">
        <div class="container">
            <header class="header-area text-center">
                <h2 class="entry-title text-uppercase">{{ trans('general.home_testimonials.title') }}</h2>
            </header>
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div id="testimonial-carousel">
                    @foreach($testimonials as $testimonial)
                    <div class="testimonial-item">
                        <div class="col-sm-2">
                            @if($testimonial->image)
                            <img src="{{ url('images/profile_picture/'.$testimonial->image) }}" alt="" class="img-circle">
                            @endif
                        </div>
                        <div class="col-sm-10">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <div class="testimonial-content">
                                    <p>{{ $testimonial->content }}</p>
                                </div>
                                <div class="testimonial-author">{{ $testimonial->title }}</div>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
    @endif

    @include('frontend.includes.home_exclusive_properties')

    @include('frontend.includes.partner')

    <div class="clearfix"></div>
@endsection