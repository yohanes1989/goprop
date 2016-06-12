<?php

namespace GoProp\Http\Controllers\Frontend\Auth;

use GoProp\Facades\ProjectHelper;
use GoProp\Models\ExtendedProfile;
use GoProp\Models\Profile;
use GoProp\Models\Subscription;
use GoProp\Models\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Laravel\Socialite\Facades\Socialite;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Validator;
use Illuminate\Http\Request;
use GoProp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    protected $username = 'email';

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct(Request $request)
    {
        $this->middleware('guest', ['except' => 'getLogout']);

        $this->redirectTo = route('frontend.account.dashboard');
        $this->loginPath = route('frontend.account.login');
    }

    public function getRegister()
    {
        $subscriptions = Subscription::all();

        $user = new User();

        $jsValidator = JsValidatorFacade::make($this->getRules([]));

        return view('frontend.account.register', [
            'validator' => $jsValidator,
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

        $requestValues = $request->all();
        if(isset($requestValues['profile']) && isset($requestValues['profile']['name'])){
            $exploded = explode(' ', $requestValues['profile']['name']);
            $requestValues['profile']['first_name'] = $exploded[0];
            unset($exploded[0]);
            unset($requestValues['profile']['name']);

            if(isset($exploded[1])){
                $requestValues['profile']['last_name'] = implode(' ', $exploded);
            }
        }

        $user = $this->create($requestValues);
        $user->assignRole('authenticated_user');

        $globalCartOrder = ProjectHelper::getGlobalCartOrder();

        if(!empty($globalCartOrder)){
            Auth::login($user);

            return redirect()->route('frontend.property.create')->with('messages', [trans('account.register.successful_message')]);
        }else{
            return redirect(route('frontend.account.login').'#login-form')->with('messages', [trans('account.register.successful_message')]);
        }
    }

    public function getLogin()
    {
        return view('frontend.account.login');
    }

    public function authFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function authFacebookHandle()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect()->route('frontend.account.auth.facebook');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect(route('frontend.account.dashboard'));
    }

    protected function getRules(array $data)
    {
        $allowedSubscriptions = Subscription::all()->pluck('slug')->all();

        $rules = [
            //'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'profile.name' => 'required|min:2',
            'profile.mobile_phone_number' => 'required|min:5',
            //'profile.home_phone_number' => 'min:5',
            //'profile.profile_picture' => 'image|max:500',
            //'profile.address' => 'required',
            //'profile.province' => 'required|not_in:0',
            //'profile.city' => 'required|not_in:0',
            //'profile.subdistrict' => 'required|not_in:0',
            //'profile.postal_code' => 'required',
            //'profile.extendedProfile.property_to_sell' => 'required',
            //'profile.extendedProfile.property_to_let' => 'required',
            'profile.extendedProfile.referral_source' => 'required',
        ];

        /*if(isset($data['subscriptions'])){
            foreach($data['subscriptions'] as $idx=>$submittedSubscription){
                $rules['subscriptions.'.$idx] = 'in:'.implode(',', $allowedSubscriptions);
            }
        }*/

        return $rules;
    }

    protected function validator(array $data)
    {
        $rules = $this->getRules($data);

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

        if(isset($data['subscriptions'])){
            $subscriptions = [];
            foreach($data['subscriptions'] as $subscriptionSlug){
                $subscriptions[] = Subscription::findBySlug($subscriptionSlug)->id;
            }

            $user->subscriptions()->sync($subscriptions);
        }

        return $user;
    }

    protected function findOrCreateUser($socialUser)
    {
        $authUser = User::where('facebook_id', $socialUser->getId())->orWhere('email', $socialUser->getEmail())->first();

        if ($authUser){
            return $authUser;
        }

        $user = User::create([
            'email' => $socialUser->getEmail(),
            'facebook_id' => $socialUser->getId(),
        ]);

        $user->assignRole('authenticated_user');

        //Set Name
        $exploded = explode(' ', $socialUser->getName());

        $profile = new Profile();
        $profile->first_name = $exploded[0];
        unset($exploded[0]);

        if(isset($exploded[1])){
            $profile->last_name = implode(' ', $exploded);
        }

        $profile->user()->associate($user);

        /*
        if(!empty($data['profile']['profile_picture']) && $data['profile']['profile_picture']->isValid()){
            $profile->profile_picture = $profile->saveProfilePicture($data['profile']['profile_picture']);
        }
        */

        $profile->profile_picture = $profile->saveRemoteProfilePicture($socialUser->getAvatar());

        $profile->save();

        $extendedProfile = new ExtendedProfile();
        $profile->extendedProfile()->save($extendedProfile);

        $subscriptions = Subscription::all()->pluck('id')->all();
        $user->subscriptions()->sync($subscriptions);

        return $user;
    }
}

