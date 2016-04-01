<?php

namespace GoProp\Http\Requests\Admin;

use GoProp\Facades\AgentHelper;
use GoProp\Http\Requests\Request;
use GoProp\Models\User;
use GoProp\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class AccountFormRequest extends Request
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

        $rules = [
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'confirmed|min:6',
            'profile.first_name' => 'required|min:2',
            'profile.last_name' => 'min:2',
            'profile.mobile_phone_number' => 'required|min:5',
            'profile.profile_picture' => 'image|max:500',
            'profile.address' => 'required',
            'profile.province' => 'required|not_in:0',
            'profile.city' => 'required|not_in:0',
            'profile.subdistrict' => 'required|not_in:0',
            'profile.postal_code' => ''
        ];

        if($user->email != $this->input('email')){
            $rules['password'] = $rules['password'].'|required';
        }

        return $rules;
    }
}