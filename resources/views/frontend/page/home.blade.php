@extends('frontend.master.layout_with_slider')

@section('page_class', 'index-page')

@section('slideshow_content')
    <img src="{{ asset('assets/frontend/images/banner-1.jpg') }}" class="img-responsive" alt="">
@endsection

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
    <section class="service-columns">
        <div class="container">
            <div class="col-sm-4 box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/save-money.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Save Money</h3>
                    <div class="entry-desc">Cheaper commission</div>
                </header>
                <div class="entry-content">
                    <a href="" class="btn btn-yellow">Find out more&hellip;</a>
                </div>
            </div>
            <div class="col-sm-4 box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/sell-online.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Sell Online</h3>
                    <div class="entry-desc">More eyes on your property</div>
                </header>
                <div class="entry-content">
                    <a href="" class="btn btn-yellow">Get started&hellip;</a>
                </div>
            </div>
            <div class="col-sm-4 box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/need-help.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Need Help</h3>
                    <div class="entry-desc">We provide many services</div>
                </header>
                <div class="entry-content">
                    <a href="" class="btn btn-yellow">Contact us&hellip;</a>
                </div>
            </div>
        </div>
    </section><!-- end of service-columns -->

    @include('frontend.includes.call_request_home')

    <section class="intro-columns">
        <div class="container">
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
                <header class="header-area text-center">
                    <h2 class="entry-title text-uppercase">Advertise your property online<br> with trusted partner</h2>
                </header>
                <div class="entry-content text-center">
                    <p>GoProp offers you a whole new way of selling or renting your property. Our team of property experts provides you everything you need to ensure your property is handled in the best way straight from the beginning up to the end. Not only that, our online services also allows you to get the best value out of your property with less hassle and less money than the conventional way.</p>
                    <p>We made this possible by cutting all the operational costs and moving most of the works to automated online based. One example is our mobile apps, which makes it easier for you to track your property sale and receive instant notifications directly into your phone.</p>
                </div>
            </div>
            <div class="col-xs-1"></div>
        </div>
    </section><!-- end of intro-columns -->

    <section class="intro-columns">
        <div class="container">
            <div class="col-xs-12">
                <header class="header-area text-center">
                    <h2 class="entry-title text-uppercase">Hop we can help sell your property easily</h2>
                </header>
            </div>
            <div class="col-sm-5ths box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/save-money.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Choose your package</h3>
                    <div class="entry-desc">We'll prepare everything you need, from floor plan to professional photos</div>
                </header>
            </div>
            <div class="col-sm-5ths box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/get-listed.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Get Listed</h3>
                    <div class="entry-desc">Your property will be advertised on the biggest national property portals such as rumah.com, rumah123.com, lamudi.com, etc.</div>
                </header>
            </div>
            <div class="col-sm-5ths box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/screening-buyers.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Screening Potential Buyers</h3>
                    <div class="entry-desc">We will screen potential buyers, arrange viewings and gather feedback for you</div>
                </header>
            </div>
            <div class="col-sm-5ths box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/negotiation.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Negotiation</h3>
                    <div class="entry-desc">We'll help you get the best price your property</div>
                </header>
            </div>
            <div class="col-sm-5ths box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/property-sold.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Property Sold</h3>
                    <div class="entry-desc">Our team will guide and oversee your property sale up to completion</div>
                </header>
            </div>
            <div class="col-xs-12">
                <div class="entry-content text-center">
                    <a href="" class="btn btn-yellow">Learn more</a>
                </div>
            </div>
        </div>
    </section><!-- end of intro-columns -->

    <section class="intro-columns">
        <div class="container">
            <div class="col-xs-12">
                <header class="header-area text-center">
                    <h2 class="entry-title text-uppercase">Why choose GoProp?</h2>
                </header>
            </div>
            <div class="col-sm-5ths box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/save-more-money.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Save More Money</h3>
                    <div class="entry-desc">We take less commission and cheaper fee than traditional property agents</div>
                </header>
            </div>
            <div class="col-sm-5ths box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/aio-online-tools.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">All In One Online Tools</h3>
                    <div class="entry-desc">Our site and mobile apps are simple to use and give you all to the details you need at the touch of your fingers</div>
                </header>
            </div>
            <div class="col-sm-5ths box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/quick-sale.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Quick Sale</h3>
                    <div class="entry-desc">Our online networks help you sell property faster than others</div>
                </header>
            </div>
            <div class="col-sm-5ths box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/pro-photography.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Professional Photography</h3>
                    <div class="entry-desc">Presentation is everything. And with our professional photography service, your property will look more attractive to potential buyers</div>
                </header>
            </div>
            <div class="col-sm-5ths box-child">
                <div class="img-wrap">
                    <img src="{{ asset('assets/frontend/images/big-reach.png') }}">
                </div>
                <header class="entry-header">
                    <h3 class="entry-title">Bigger Reach</h3>
                    <div class="entry-desc">By advertising our property on the biggest national property will be seen by milions potential buyers</div>
                </header>
            </div>
        </div>
    </section><!-- end of intro-columns -->

    <section class="property-table-columns">
        <div class="container">
            <div class="col-xs-12">
                <header class="header-area text-center">
                    <h2 class="entry-title text-uppercase">What do you need?</h2>
                </header>
            </div>
            <div class="col-xs-12">
                {!! Form::open(['route' => ['frontend.property.add_to_cart']]) !!}
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
                                                        <input type="text"  data-package="{{ $package->id }}" value="5000000000" class="property-price form-control text-center">
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
    </section><!-- end of property-table-columns -->

    @include('frontend.includes.price_saving_home')

    <section class="testimonial-columns">
        <div class="container">
            <header class="header-area text-center">
                <h2 class="entry-title text-uppercase">What Our Clients Say</h2>
            </header>
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
                <div id="testimonial-carousel">
                    <?php for ($i=0; $i < 4; $i++) { ?>
                    <div class="testimonial-item">
                        <div class="col-xs-2">
                            <img src="{{ asset('assets/frontend/images/avatar.jpg') }}" alt="" class="img-circle">
                        </div>
                        <div class="col-xs-10">
                            <div class="col-xs-1"></div>
                            <div class="col-xs-10">
                                <div class="testimonial-content">
                                    <p>After a particularly bad experience with our previous agent when we sold our first home, we wanted something completely different when we decided to sell our second house. We're so glad we found GoProp, the process is much faster, simpler, and well organized! The mobile app really helps speed up the process of arranging viewings schedule and keeping us up to date with everything going on with our property.</p>
                                </div>
                                <div class="testimonial-author">Adrian and Lisa, DKI Jakarta, Property sold within 10 days on GoProp</div>
                            </div>
                            <div class="col-xs-1"></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-1"></div>
        </div>
    </section>

    @include('frontend.includes.home_exclusive_properties')

    @include('frontend.includes.partner')

    <div class="clearfix"></div>
@endsection