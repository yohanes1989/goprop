<div id="price-saving-widget" class="calculate-price-widget estimated-property-sale">
    <div class="form-begin" style="padding: 0 10px;">
        <div class="form-group">
            <label>{{ trans('property.price_saving_widget.estimated_property_price') }}</label>
            <input type="text" id="inputPropertyPrice" value="" data-min="10000000" data-max="5000000000"
                   data-step="5000000" data-from="2500000000" />
        </div>
        <div class="form-group">
            <small>{{ trans('property.price_saving_widget.adjust_price') }}</small>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-detail">
        <strong>{{ trans('property.price_saving_widget.you_save') }}:</strong>
        <h2 class="entry-title">IDR <span class="saved-value"></span>**</h2>
        <p>** {!! trans('property.price_saving_widget.terms') !!}</p>
    </div>
</div>