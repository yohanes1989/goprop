<div class="propertyItem-child">
    <div class="col-sm-6">
        <div class="img-wrap">
            <a href="{{ route('frontend.property.view', ['for' => $for, 'id' => $property->id]) }}"><img src="{{ url('images/property_thumbnail/'.$property->getPhotoThumbnail()) }}" class="img-responsive"></a>
        </div>
    </div>
    <div class="col-sm-6 account-property-detail">
        <ul class="list-unstyled">
            <li><a data-toggle="tooltip" title="{{ trans('property.buttons.talk_to_agent') }}" href="{{ route('frontend.account.inbox', ['property_id' => $property->id, 'new' => 1]) }}"><img src="{{ asset('assets/frontend/images/icon-small-email.png') }}"></a></li>
            @if($property->user_id != \Illuminate\Support\Facades\Auth::user()->id)
            <li>
                <a data-toggle="tooltip"  title="{{ trans('property.buttons.schedule_viewing') }}" href="{{ route('frontend.property.schedule_viewing', ['id' => $property->id]) }}" class="ajax_popup fancybox.ajax">
                    <img src="{{ asset('assets/frontend/images/icon-small-date.png') }}">
                </a>
            </li>
            @endif
            @if($property->status == \GoProp\Models\Property::STATUS_DRAFT)
                <li><a data-toggle="tooltip" title="{{ trans('property.buttons.edit_property') }}" href="{{ route('frontend.property.edit', ['id' => $property->id]) }}"><img src="{{ asset('assets/frontend/images/icon-small-bookmark.png') }}"></a></li>
            @endif
        </ul>
        <header class="entry-header">
            <h4 class="entry-title"><a href="{{ route('frontend.property.view', ['for' => $for, 'id' => $property->id]) }}">{{ $property->property_name }}</a></h4>
            <div class="entry-desc">
                {{ trans('property.for.'.$for.'_property_title', ['name' => trans('property.property_type.'.$property->type->slug)]) }}<br/>
                {{ $property->subdistrict_name, $property->city_name }}
            </div>
        </header>
        <div class="entry-content">
            @if($property->isResidential())
                <div class="featureChild">
                    <div class="name">{{ $property->rooms }}</div>
                    <div class="desc">{{ trans_choice('property.index.bedrooms', $property->rooms) }}</div>
                </div>
                <div class="featureChild">
                    <div class="name">{{ $property->bathrooms }}</div>
                    <div class="desc">{{ trans_choice('property.index.bathrooms', $property->bathrooms) }}</div>
                </div>
            @endif
            <div class="clearfix"></div>

            <h3 class="entry-price">
                {{ \GoProp\Facades\ProjectHelper::formatNumber($property->getPrice($for), true) }}
                {!! ($for == 'rent')?'<br/>('.trans('property.rent_price_type.'.$property->rent_price_type).')':'' !!}
            </h3>
        </div>
    </div>
</div>