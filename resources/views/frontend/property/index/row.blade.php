<div class="propertyItem-child row">
    <div class="col-sm-5">
        <div class="img-wrap">
            <a href="{{ route('frontend.property.view', ['for' => $for, 'id' => $property->id]) }}"><img src="{{ url('images/property_thumbnail/'.$property->getPhotoThumbnail()) }}" class="img-responsive"></a>
        </div>
    </div>
    <div class="col-sm-7 account-property-detail">
        <header class="entry-header clearfix">
            <h4 class="entry-price">
                @include('frontend.property.includes.price')
            </h4>

            <h4 class="entry-title"><a href="{{ route('frontend.property.view', ['for' => $for, 'id' => $property->id]) }}">{{ $property->property_name }}</a></h4>

            <div class="entry-desc">
                {{ trans('property.for.'.$for.'_property_title', ['name' => trans('property.property_type.'.$property->type->slug)]) }}
            </div>
        </header>

        <div class="entry-content">
            @if(!empty($property->land_size+0))
                <div class="featureChild">
                    <span class="name">{{ trans('forms.fields.property.land_size') }}:</span>
                    <span class="desc">{!! $property->land_size.' m<sup>2</sup>' !!}</span>
                </div>
            @endif

            @if(!empty($property->building_size+0))
                <div class="featureChild">
                    <span class="name">{{ trans('forms.fields.property.building_size') }}:</span>
                    <span class="desc">{!! $property->building_size.' m<sup>2</sup>' !!}</span>
                </div>
            @endif

            @if($property->isResidential())
                <div class="clearfix"></div>

                <div class="featureChild">
                    <span class="name">{{ $property->rooms }}</span>
                    <span class="desc">{{ trans_choice('property.index.bedrooms', $property->rooms) }}</span>
                </div>
                <div class="featureChild">
                    <span class="name">{{ $property->bathrooms }}</span>
                    <span class="desc">{{ trans_choice('property.index.bathrooms', $property->bathrooms) }}</span>
                </div>
            @endif

            @if($property->isOwner(\Illuminate\Support\Facades\Auth::user()))
                <div class="clearfix"></div>
                <div class="featureChild">
                    <strong>
                    <span class="name">Status:</span>
                    <span class="desc">{{ trans('property.status.'.$property->status) }}</span>
                    </strong>
                </div>
            @endif

            <div class="clearfix"></div>

            <div class="user-info">
            <ul class="list-unstyled">
                <li><a data-toggle="tooltip" title="{{ trans('property.buttons.talk_to_agent') }}" href="{{ route('frontend.account.inbox', ['property_id' => $property->id, 'new' => 1]) }}"><img src="{{ asset('assets/frontend/images/property-agent.png') }}"></a></li>
                @if($property->user_id != \Illuminate\Support\Facades\Auth::user()->id)
                    <li>
                        <a data-toggle="tooltip"  title="{{ trans('property.buttons.schedule_viewing') }}" href="{{ route('frontend.property.schedule_viewing', ['id' => $property->id]) }}" class="ajax_popup fancybox.ajax">
                            <img src="{{ asset('assets/frontend/images/icon-small-date.png') }}">
                        </a>
                    </li>
                @endif
                <li><a data-toggle="tooltip" title="{{ trans('property.buttons.edit_property') }}" href="{{ route('frontend.property.edit', ['id' => $property->id]) }}"><img src="{{ asset('assets/frontend/images/property-edit.png') }}"></a></li>

                @if(in_array($property->status, [\GoProp\Models\Property::STATUS_ACTIVE]))
                <li><a data-toggle="tooltip" data-confirm="{{ trans('property.view.unpublish_confirm') }}" title="{{ trans('property.buttons.disable') }}" href="{{ route('frontend.property.set_unpublish', ['id' => $property->id]) }}"><img src="{{ asset('assets/frontend/images/property-delete.png') }}"></a></li>
                @endif

                @if(in_array($property->status, [\GoProp\Models\Property::STATUS_INACTIVE]))
                    <li><a data-toggle="tooltip" title="{{ trans('property.buttons.enable') }}" href="{{ route('frontend.property.set_unpublish', ['id' => $property->id]) }}"><img src="{{ asset('assets/frontend/images/property-publish.png') }}"></a></li>
                @endif
            </ul>
            </div>
        </div>
    </div>
</div>