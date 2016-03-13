@if($propertiesInComparison->count() > 0)
    <div class="property-compare-wrapper clearfix">
        <h3 class="entry-title">{{ trans('property.property_comparison.compare_properties') }}</h3>
        <div class="property-compare-list">
            @foreach($propertiesInComparison as $propertyInComparison)
                <div class="propertyCompare-child">
                    <div class="img-wrap">
                        <a href="{{ route('frontend.property.view', ['id' => $propertyInComparison->id]) }}"><img src="{{ url('images/property_thumbnail/'.$propertyInComparison->getPhotoThumbnail()) }}"></a>

                        <div class="user-info">
                            <ul class="list-unstyled">
                                <li><a data-toggle="tooltip" title="{{ trans('property.property_comparison.tooltip_uncompare') }}" href="{{ route('frontend.property.compare.remove', ['id' => $propertyInComparison->id]) }}"><i class="fa fa-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="propertyCompare-child btn-submit">
                <a href="{{ route('frontend.property.compare') }}" class="btn btn-yellow btn-shadow">{{ trans('property.property_comparison.compare_btn') }}</a>
            </div>
        </div>
    </div>
@endif