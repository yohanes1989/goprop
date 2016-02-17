<?php

namespace GoProp\Http\Controllers\Frontend\Auth;

use GoProp\Facades\ProjectHelper;
use GoProp\Models\ExtendedProfile;
use GoProp\Models\Profile;
use GoProp\Models\Subscription;
use GoProp\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use GoProp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    protected $username = 'username';

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct(Request $request)
    {
        $this->middleware('guest', ['except' => 'getLogout']);

        $this->redirectTo = route('frontend.account.dashboard');
    }

    public function getRegister()
    {
        $subscriptions = Subscription::all();

        $user = new User();

        return view('frontend.account.register', [
            'model' => $user,
            'subscriptions' => $subscriptions
        ]);
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());
        $user->assignRole('authenticated_user');

        $globalCartOrder = ProjectHelper::getGlobalCartOrder();

        if(!empty($globalCartOrder)){
            Auth::login($user);

            return redirect()->route('frontend.property.create')->with('messages', [trans('account.register.successful_message')]);
        }else{
            return redirect()->route('frontend.account.login')->with('messages', [trans('account.register.successful_message')]);
        }
    }

    public function getLogin()
    {
        return view('frontend.account.login');
    }

    protected function validator(array $data)
    {
        $allowedSubscriptions = Subscription::lists('slug')->all();

        $rules = [
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'profile.first_name' => 'required|min:2',
            'profile.last_name' => 'min:2',
            'profile.mobile_phone_number' => 'required|min:5',
            'profile.home_phone_number' => 'min:5',
            'profile.profile_picture' => 'image|max:500',
            //'profile.address' => 'required',
            //'profile.province' => 'required|not_in:0',
            //'profile.city' => 'required|not_in:0',
            //'profile.subdistrict' => 'required|not_in:0',
            //'profile.postal_code' => 'required',
            //'profile.extendedProfile.property_to_sell' => 'required',
            //'profile.extendedProfile.property_to_let' => 'required',
            'profile.extendedProfile.referral_source' => 'required',
        ];

        foreach($data['subscriptions'] as $idx=>$submittedSubscription){
            $rules['subscriptions.'.$idx] = 'in:'.implode(',', $allowedSubscriptions);
        }

        return Validator::make($data, $rules);
    }

    protected function create(array $data)
    {
        $user = new User($data);
        $user->password = bcrypt($data['password']);
        $user->save();

        $profile = new Profile($data['profile']);
        $profile->user()->associate($user);

        if(!empty($data['profile']['profile_picture']) && $data['profile']['profile_picture']->isValid()){
            $profile->profile_picture = $profile->saveProfilePicture($data['profile']['profile_picture']);
        }

        $profile->save();

        $extendedProfile = new ExtendedProfile($data['profile']['extendedProfile']);
        $profile->extendedProfile()->save($extendedProfile);

        $subscriptions = [];
        foreach($data['subscriptions'] as $subscriptionSlug){
            $subscriptions[] = Subscription::findBySlug($subscriptionSlug)->id;
        }

        $user->subscriptions()->sync($subscriptions);

        return $user;
    }
}

