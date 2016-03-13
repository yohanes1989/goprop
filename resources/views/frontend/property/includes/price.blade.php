<?php
$priceLabel = [];

if($property->for_sell){
    $priceLabel[] = \GoProp\Facades\ProjectHelper::formatNumber($property->getPrice('sell'), true);
}
if($property->for_rent){
    $priceLabel[] = \GoProp\Facades\ProjectHelper::formatNumber($property->getPrice('rent'), true).' ('.trans('property.rent_price_type.'.$property->rent_price_type).')';
}
?>
{!! implode(' / ', $priceLabel) !!}