<?php

namespace GoProp\Http\Requests\Admin;

use GoProp\Http\Requests\Request;
use GoProp\Models\Property;
use GoProp\Models\PropertyType;
use GoProp\Models\Package;

class PropertyFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $propertyTypeAllowedValues = implode(',', PropertyType::lists('id')->all());
        $rentPriceTypeAllowedValues = implode(',', array_keys(Property::getRentTypeLabel()));
        $viewingSchedulesAllowedValues = implode(',', array_keys(Property::getViewingScheduleOptionLabel()));
        $propertyFurnishingAllowedValues = implode(',', array_keys(Property::getFurnishingLabel()));

        $rules['owner'] = 'required|email';
        $rules['property_name'] = 'required';
        $rules['province'] = 'required';
        $rules['city'] = 'required';
        $rules['subdistrict'] = 'required';
        $rules['address'] = 'required';
        $rules['postal_code'] = 'required';
        $rules['property_type_id'] = 'required|in:'.$propertyTypeAllowedValues;
        $rules['parking'] = 'required';
        $rules['garage_size'] = 'required_if:parking,garage';
        $rules['rooms'] = 'required';
        $rules['furnishing'] = 'required|in:'.$propertyFurnishingAllowedValues;
        $rules['bathrooms'] = 'required';
        $rules['for_sell'] = 'required|in:0,1';
        $rules['sell_price'] = 'required_if:for_sell,1';
        $rules['sell_viewing_schedule'] = 'required_if:for_sell,1';
        foreach($this->input('sell_viewing_schedule', []) as $idx => $sellViewingSchedule){
            $rules['sell_viewing_schedule.'.$idx] = 'in:'.$viewingSchedulesAllowedValues;
        }
        $rules['for_rent'] = 'required|in:0,1';
        $rules['rent_price'] = 'required_if:for_rent,1';
        $rules['rent_price_type'] = 'required_if:for_rent,1|in:'.$rentPriceTypeAllowedValues;
        $rules['rent_viewing_schedule'] = 'required_if:for_rent,1';
        foreach($this->input('rent_viewing_schedule', []) as $idx => $rentViewingSchedule){
            $rules['rent_viewing_schedule.'.$idx] = 'in:'.$viewingSchedulesAllowedValues;
        }

        $certificateAllowedValues = implode(',', array_keys(Property::getCertificateLabel()));

        $rules['land_size'] = 'numeric';
        $rules['building_size'] = 'numeric';
        $rules['floor'] = 'numeric';
        $rules['certificate'] = 'in:'.$certificateAllowedValues;
        $rules['virtual_tour_url'] = 'url';
        $rules['description'] = 'required|min:10|max:300';

        $rules['latitude'] = 'required';
        $rules['longitude'] = 'required';

        $allowedPackages = implode(',', Package::lists('id')->toArray());

        $rules['package'] = 'required|in:'.$allowedPackages;

        $package = Package::findOrFail($this->input('package'));
        $allowedFeatures = implode(',', $package->features->lists('id')->toArray());

        foreach($this->input('features', []) as $featureIdx => $feature){
            $rules['features.'.$featureIdx] = 'in:'.$allowedFeatures;
        }

        return $rules;
    }
}