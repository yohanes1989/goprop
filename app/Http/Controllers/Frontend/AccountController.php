<?php

namespace GoProp\Http\Controllers\Frontend;

use GoProp\Facades\AddressHelper;
use GoProp\Http\Controllers\Controller;
use GoProp\Models\Property;
use GoProp\Models\Message;
use GoProp\Models\User;
use GoProp\Models\ViewingSchedule;
use Illuminate\Support\Facades\Auth;
use GoProp\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GoProp\Facades\ProjectHelper;

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

        if($property->status == Property::STATUS_DRAFT){
            return redirect()->back()->withErrors([trans('property.messages.unauthorized_access')]);
        }

        $user = Auth::user();
        $qb = $user->likedProperties();
        AddressHelper::addAddressQueryScope($qb->getQuery());

        $interested_properties = $qb->get();

        $myPropertiesQb = $user->properties()->whereNotIn('status', [Property::STATUS_DRAFT]);
        AddressHelper::addAddressQueryScope($myPropertiesQb->getQuery());
        $my_properties = $myPropertiesQb->get();

        $confirmedViewingSchedule = null;

        if($property){
            $confirmedViewingSchedule = ViewingSchedule::confirmed()
                ->where('property_id', $property->id)
                ->where('user_id', $user->id)
                ->first();
        }

        return view('frontend.account.inbox', [
            'interested_properties' => $interested_properties,
            'property' => $property,
            'conversation' => $user->getPropertyConversation($property),
            'user' => $user,
            'confirmedViewingSchedule' => $confirmedViewingSchedule,
            'my_properties' => $my_properties
        ]);
    }

    public function postSendMessage(Request $request, $property_id = NULL)
    {
        $rules = [
            'message' => 'required'
        ];

        $this->validate($request, $rules);

        $property = Property::find($property_id);
        $property->load('agent');

        $user = Auth::user();


        if($property->agent){
            $agent = $property->agent;
        }else{
            $agent = ProjectHelper::getDefaultAgent();
        }

        $conversation = $user->getPropertyConversation($property);
        if($conversation){
            $agent = $conversation->recipient;
        }else{
            $conversation = $user->createPropertyConversation($property, $agent);
        }

        $message = new Message([
            'message' => $request->input('message')
        ]);
        $message->sender()->associate($user);
        if($agent){
            $message->recipient()->associate($agent);
        }
        $message->referenced()->associate($property);
        $message->parentMessage()->associate($conversation);
        $message->save();

        if($request->ajax()){
            $return = [
                'message' => [
                    'id' => $message->id,
                    'text' => $message->message
                ]
            ];

            return response()->json($return);
        }

        return redirect()->back()->with('messages', [trans('property.inbox.sent_message')]);
    }

    public function getReplies(Request $request, $property_id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($property_id);

        $conversation = $user->getPropertyConversation($property);
        $replies = $conversation->replies()->where('id', '>', $request->get('lastID'))->get();

        $return['chats'] = [];

        foreach($replies as $reply) {
            $return['chats'][] = [
                'id' => $reply->id,
                'class' => ($reply->sender_id == $conversation->sender_id)?'chat-self':'chat-reply',
                'text' => $reply->message,
                'time' => $reply->created_at->format('d M Y H:i')
            ];
        }

        return response()->json($return);
    }

    public function getViewings()
    {
        $user = Auth::user();

        $viewingSchedules = ViewingSchedule::confirmed()
            ->where('user_id', $user->id)
            ->get();

        return view('frontend.account.viewings', [
            'viewingSchedules' => $viewingSchedules
        ]);
    }

    public function getViewingsData(Request $request)
    {
        $user = Auth::user();

        $viewingSchedules = $user->viewingSchedules()
            ->confirmed()
            ->where('viewing_from', '>=', \DateTime::createFromFormat('Y-m-d', $request->input('start')))
            ->where('viewing_until', '<=', \DateTime::createFromFormat('Y-m-d', $request->input('end')))
            ->get();

        $return = [];

        foreach($viewingSchedules as $viewingSchedule){
            $return[] = [
                'title' => $viewingSchedule->property->property_name,
                'start' => $viewingSchedule->viewing_from->toIso8601String(),
                'end' => $viewingSchedule->viewing_until->toIso8601String(),
                'className' => 'bg-green'
            ];
        }

        return response()->json($return);
    }

    public function getViewingsMyPropertiesData(Request $request)
    {
        $user = Auth::user();
        $myProperties = $user->properties->lists('id');

        $viewingSchedules = ViewingSchedule::confirmed()
            ->whereIn('property_id', $myProperties->all())
            ->where('viewing_from', '>=', \DateTime::createFromFormat('Y-m-d', $request->input('start')))
            ->where('viewing_until', '<=', \DateTime::createFromFormat('Y-m-d', $request->input('end')))
            ->get();

        $return = [];

        foreach($viewingSchedules as $viewingSchedule){
            $return[] = [
                'title' => $viewingSchedule->property->property_name,
                'start' => $viewingSchedule->viewing_from->toIso8601String(),
                'end' => $viewingSchedule->viewing_until->toIso8601String(),
                'className' => 'bg-yellow'
            ];
        }

        return response()->json($return);
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