<div class="exclusive-property-carousel">
    <div id="exclusivePropertyWidget-list">
        <?php
            $exclusiveProperties = \GoProp\Facades\ProjectHelper::getExclusiveProperties(5);
        ?>
        @foreach($exclusiveProperties as $exclusiveProperty)
        <div class="exclusiveProperty-item">
            <a href="{{ route('frontend.property.view', ['id' => $exclusiveProperty->id, 'for' => $exclusiveProperty->exclusive_type]) }}">
                @if($exclusiveProperty->photos->count() > 0)
                <img src="{{ url('images/exclusive_thumbnail/'.$exclusiveProperty->photos->first()->filename) }}" />
                @endif
                <div class="exclusiveProperty-overlay">
                    <div class="exclusiveProperty-detail">
                        <h3 class="entry-title">{{ $exclusiveProperty->property_name }}</h3>
                        <div class="entry-desc">{{ \GoProp\Facades\AddressHelper::getAddressLabel($exclusiveProperty->subdistrict, 'subdistrict') }}, {{ \GoProp\Facades\AddressHelper::getAddressLabel($exclusiveProperty->city, 'city') }}</div>
                        <div class="entry-sale">{{ trans('property.for.'.$exclusiveProperty->exclusive_type.'_property_title', ['name' => trans('property.property_type.'.$exclusiveProperty->type->slug)]) }}</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>