{{ \GoProp\Facades\ProjectHelper::formatNumber($property->getPrice($for), true) }}
{!! ($for == 'rent')?' ('.trans('property.rent_price_type.'.$property->rent_price_type).')':'' !!}