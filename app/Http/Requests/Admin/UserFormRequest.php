<?php

namespace GoProp\Http\Requests\Admin;

use GoProp\Http\Requests\Request;
use GoProp\Models\User;
use GoProp\Models\Subscription;

class UserFormRequest extends Request
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
        $allowedSubscriptions = Subscription::lists('slug')->all();
        $allowedStatus = array_keys(User::getStatusLabel());

        $routeName = $this->route()->getName();

        $rules = [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'confirmed|min:6',
            'status' => 'required|in:'.implode(',', $allowedStatus),
            'profile.first_name' => 'required|min:2',
            'profile.last_name' => 'min:2',
            'profile.mobile_phone_number' => 'required|min:5',
            'profile.home_phone_number' => 'min:5',
            'profile.profile_picture' => 'image|max:500',
            'profile.address' => 'required',
            'profile.province' => 'required|not_in:0',
            'profile.city' => 'required|not_in:0',
            'profile.subdistrict' => 'required|not_in:0',
            'profile.postal_code' => 'required'
        ];

        if(in_array($routeName, ['admin.member.store', 'admin.member.update'])){
            $rules['profile.extendedProfile.property_to_sell'] = 'required';
            $rules['profile.extendedProfile.property_to_let'] = 'required';
            $rules['profile.extendedProfile.referral_source'] = 'required';
        }

        if($this->route()->hasParameter('id')){
            $member = User::findOrFail($this->route('id'));

            $rules['username'] = $rules['username'].'|unique:users,username,'.$member->id;
            $rules['email'] = $rules['email'].'|unique:users,email,'.$member->id;
        }else{
            $rules['password'] = $rules['password'].'|required';
            $rules['username'] = $rules['username'].'|unique:users';
            $rules['email'] = $rules['email'].'|unique:users';
        }

        foreach ($this->input('subscriptions', []) as $idx => $submittedSubscription) {
            $rules['subscriptions.' . $idx] = 'in:' . implode(',', $allowedSubscriptions);
        }

        return $rules;
    }
}