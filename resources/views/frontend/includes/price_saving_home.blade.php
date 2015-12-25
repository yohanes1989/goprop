<section class="saleprice-columns">
    <div class="container">
        <div class="col-sm-1"></div>
        <div class="col-sm-4">
            <div class="widget-child">
                <div id="price-saving-calculator" class="calculate-price-widget">
                    <div class="form-group">
                        <label>{{ trans('property.price_saving_widget.estimated_property_price') }}</label>
                        <input class="onlyNumber formatNumberOnType property-price" type="text" class="form-control" value="1000000000">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('property.price_saving_widget.other_agent_commission') }}</label>
                        <input class="onlyNumber agent-commission form-control" type="text" value="2.5">
                    </div>
                    <div class="form-group">
                        <button id="calculate-saved-price-btn" class="btn btn-grey">{{ trans('property.price_saving_widget.calculate_btn') }}</button>
                    </div>
                    <div class="form-detail">
                        <strong>{{ trans('property.price_saving_widget.you_save') }}:</strong>
                        <h2 class="entry-title">IDR <span class="saved-value"></span>**</h2>
                        <p>** {{ trans('property.price_saving_widget.other_agent_term') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2 hidden-xs">
            <div class="widget-child">
                <div class="widget-divider">
                    <div class="widget-divider-inner">
                        <span>{{ trans('property.price_saving_widget.or') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="widget-child">
                <div id="price-saving-widget" class="calculate-price-widget estimated-property-sale">
                    <div class="form-begin">
                        <div class="form-group">
                            <label>{{ trans('property.price_saving_widget.estimated_property_price') }}</label>
                            <input type="text" id="inputPropertyPrice" value="" data-slider-min="100000000" data-slider-max="2000000000"
                                   data-slider-step="500000" data-slider-value="1000000000" />
                        </div>
                        <div class="form-group">
                            <small>{{ trans('property.price_saving_widget.adjust_price') }}</small>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-detail">
                        <strong>{{ trans('property.price_saving_widget.you_save') }}:</strong>
                        <h2 class="entry-title">IDR <span class="saved-value"></span>**</h2>
                        <p>** {{ trans('property.price_saving_widget.terms') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>
</section>