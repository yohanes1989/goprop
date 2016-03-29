<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use GoProp\Http\Requests\Admin\UserFormRequest;
use GoProp\Models\ExtendedProfile;
use GoProp\Models\Profile;
use GoProp\Models\User;
use GoProp\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        $qb = User::with('profile');
        $qb->whereHas('roles', function($query){
            $query->where('slug', 'authenticated_user');
        });

        $members = $qb->paginate(50);

        return view('admin.members.index', [
            'members' => $members
        ]);
    }

    public function create()
    {
        $member = new User();
        $profile = new Profile();
        $member->profile = $profile;

        $subscriptions = Subscription::all();

        return view('admin.members.create', [
            'member' => $member,
            'subscriptions' => $subscriptions
        ]);
    }

    public function store(UserFormRequest $request)
    {
        $user = new User([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'status' => $request->input('status'),
            'password' => bcrypt($request->input('password'))
        ]);
        $user->save();
        $user->assignRole('authenticated_user');

        $profile = new Profile($request->input('profile'));
        $profile->user()->associate($user);

        if($request->hasFile('profile.profile_picture') && $request->file('profile.profile_picture')->isValid()){
            $profile->profile_picture = $profile->saveProfilePicture($request->file('profile.profile_picture'));
        }

        $extendedProfile = new ExtendedProfile($request->input('profile.extendedProfile'));

        $profile->save();
        $profile->extendedProfile()->save($extendedProfile);

        $subscriptions = [];
        foreach($request->input('subscriptions', []) as $subscriptionSlug){
            $subscriptions[] = Subscription::findBySlug($subscriptionSlug)->id;
        }

        $user->subscriptions()->sync($subscriptions);

        return redirect()->route('admin.member.index')->with('messages', [$user->username.' has been created.']);
    }

    public function edit($id)
    {
        $member = User::findOrFail($id);
        $member->load(['profile', 'profile.extendedProfile']);
        $subscriptions = Subscription::all();

        return view('admin.members.edit', [
            'member' => $member,
            'subscriptions' => $subscriptions
        ]);
    }

    public function update(UserFormRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->load(['profile', 'profile.extendedProfile']);

        $user->username = $request->input('username');
        $user->status = $request->input('status');
        $user->email = $request->input('email');

        if($request->input('remove_profile_picture') == 1){
            $user->profile->removeProfilePicture();
        }

        if($request->hasFile('profile.profile_picture') && $request->file('profile.profile_picture')->isValid()){
            $user->profile->profile_picture = $user->profile->saveProfilePicture($request->file('profile.profile_picture'));
        }

        if($request->has('password')){
            $user->password = bcrypt($request->input('password'));
        }

        $user->profile->fill($request->input('profile'));
        $user->profile->extendedProfile->fill($request->input('profile.extendedProfile'));

        $user->push();

        $subscriptions = [];
        foreach($request->input('subscriptions', []) as $subscriptionSlug){
            $subscriptions[] = Subscription::findBySlug($subscriptionSlug)->id;
        }

        $user->subscriptions()->sync($subscriptions);

        return redirect($request->get('backUrl', route('admin.member.index')))->with('messages', [$user->username.' has been updated.']);
    }

    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect($request->get('backUrl', route('admin.member.index')))->with('messages', [$user->username.' has been deleted.']);
    }

    public function findAutocomplete(Request $request)
    {
        $roles = $request->get('roles', ['authenticated_user']);
        $term = $request->get('term', '');

        $return = [];

        if(strlen($term) >= 2){
            $qb = User::whereHas('profile', function($query) use ($term){
                $query->where('first_name', 'LIKE', '%'.$term.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$term.'%')
                    ->orWhere('email', 'LIKE', '%'.$term.'%')
                    ->orWhere('username', 'LIKE', '%'.$term.'%');
            });

            $qb->whereHas('roles', function($query) use ($roles){
                $query->whereIn('slug', $roles);
            });

            $results = $qb->get();

            foreach($results as $result){
                $return[] = [
                    'label' => $result->username.' - '.$result->profile->first_name.' '.$result->profile->last_name.' ('.$result->email.')',
                    'value' => $result->email
                ];
            }
        }

        return response()->json($return);
    }
}
