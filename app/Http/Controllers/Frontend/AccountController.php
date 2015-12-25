<?php

namespace GoProp\Http\Controllers\Frontend;

use GoProp\Facades\AddressHelper;
use GoProp\Http\Controllers\Controller;
use GoProp\Models\Property;
use GoProp\Models\Message;
use GoProp\Models\User;
use Illuminate\Support\Facades\Auth;
use GoProp\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $rowLimit = 2;

        $qb = $user->properties();
        $sellProperties = $qb->where('for_sell', 1)->take($rowLimit)->get();
        $leaseProperties = $qb->where('for_rent', 1)->take($rowLimit)->get();
        $likedProperties = $user->likedProperties()->take($rowLimit)->get();

        return view('frontend.account.dashboard', [
            'rowLimit' => $rowLimit,
            'sellProperties' => $sellProperties,
            'leaseProperties' => $leaseProperties,
            'likedProperties' => $likedProperties,
        ]);
    }

    public function getProfile()
    {
        $user = Auth::user();
        $user->load(['profile', 'profile.extendedProfile', 'subscriptions']);
        $subscriptions = Subscription::all();

        return view('frontend.account.logged_in.profile', [
            'model' => $user,
            'subscriptions' => $subscriptions
        ]);
    }

    public function postProfile(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->update($request->all());

        return redirect()->route('frontend.account.profile')->with('messages', [trans('account.profile.update_successful_message')]);
    }

    public function getInbox($property_id = NULL)
    {
        $property = Property::find($property_id);

        $user = Auth::user();
        $qb = $user->likedProperties();
        AddressHelper::addAddressQueryScope($qb->getQuery());
        $interested_properties = $qb->get();

        return view('frontend.account.inbox', [
            'interested_properties' => $interested_properties,
            'property' => $property,
            'conversation' => $user->getPropertyConversation($property),
            'user' => $user
        ]);
    }

    public function postSendMessage(Request $request, $property_id = NULL)
    {
        $rules = [
            'message' => 'required'
        ];

        $this->validate($request, $rules);

        $property = Property::find($property_id);
        $user = Auth::user();

        $conversation = $user->getPropertyConversation($property);
        if($conversation){
            $agent = $conversation->recipient;
        }else{
            $agent = User::where('username', 'agent1')->firstOrFail();

            //Create new conversation
            $conversation = new Message();
            $conversation->sender()->associate($user);
            $conversation->recipient()->associate($agent);
            $conversation->referenced()->associate($property);
            $conversation->save();
        }

        $message = new Message([
            'message' => $request->input('message')
        ]);
        $message->sender()->associate($user);
        $message->recipient()->associate($agent);
        $message->referenced()->associate($property);
        $message->parentMessage()->associate($conversation);
        $message->save();

        return redirect()->back()->with('messages', [trans('property.inbox.sent_message')]);
    }

    protected function validator(array $data)
    {
        $allowedSubscriptions = Subscription::lists('slug')->all();

        $rules = [
            'username' => 'required|max:255|unique:users,username,'.Auth::user()->id,
            'email' => 'required|email|max:255|unique:users,email,'.Auth::user()->id,
            'password' => 'confirmed|min:6',
            'profile.first_name' => 'required|min:2',
            'profile.last_name' => 'min:2',
            'profile.mobile_phone_number' => 'required|min:5',
            'profile.home_phone_number' => 'min:5',
            'profile.profile_picture' => 'image|max:500',
            'profile.address' => 'required',
            'profile.province' => 'required|not_in:0',
            'profile.city' => 'required|not_in:0',
            'profile.subdistrict' => 'required|not_in:0',
            'profile.extendedProfile.property_to_sell' => 'required',
            'profile.extendedProfile.property_to_let' => 'required',
        ];

        foreach($data['subscriptions'] as $idx=>$submittedSubscription){
            $rules['subscriptions.'.$idx] = 'in:'.implode(',', $allowedSubscriptions);
        }

        return Validator::make($data, $rules);
    }

    protected function update(array $data)
    {
        $user = Auth::user();

        if(!empty($data['password'])){
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        $user->profile->fill($data['profile']);
        if(!empty($data['profile']['profile_picture']) && $data['profile']['profile_picture']->isValid()){
            $user->profile->profile_picture = $user->profile->saveProfilePicture($data['profile']['profile_picture']);
        }
        $user->profile->save();

        $user->profile->extendedProfile->fill($data['profile']['extendedProfile']);
        $user->profile->extendedProfile->save();

        $subscriptions = [];
        foreach($data['subscriptions'] as $subscriptionSlug){
            $subscriptions[] = Subscription::findBySlug($subscriptionSlug)->id;
        }

        $user->subscriptions()->sync($subscriptions);

        return $user;
    }
}