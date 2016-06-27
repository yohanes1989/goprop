<?php

namespace GoProp\Http\Requests\Admin;

use GoProp\Http\Requests\Request;
use GoProp\Models\PropertyType;
use GoProp\Models\ReferralInformation;
use Illuminate\Support\Facades\Auth;

class ReferralInformationFormRequest extends Request
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
        $user = Auth::user();
        $propertyTypeAllowedValues = implode(',', PropertyType::lists('id')->all());
        $statusAllowedValues = implode(',', array_keys(ReferralInformation::getStatusOptions()));

        if($user->is('administrator')){
            $rules['status'] = 'required|in:'.$statusAllowedValues;
            $rules['followed_up'] = 'required|boolean';
        }

        $rules['name'] = 'required';
        $rules['contact_number'] = 'required';
        $rules['email'] = 'email';
        $rules['province'] = 'required';
        $rules['city'] = 'required';
        $rules['subdistrict'] = 'required';
        $rules['address'] = 'required';
        $rules['postal_code'] = '';
        $rules['property_type_id'] = 'required|in:'.$propertyTypeAllowedValues;

        return $rules;
    }

    public function all()
    {
        $attributes = parent::all();

        if(!$this->has('followed_up')){
            $attributes['followed_up'] = 0;
        }


        $this->replace($attributes);

        return parent::all();
    }
}