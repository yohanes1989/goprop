<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use GoProp\Http\Requests\Admin\UserFormRequest;
use GoProp\Models\ExtendedProfile;
use GoProp\Models\Profile;
use GoProp\Models\User;
use GoProp\Models\Subscription;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $qb = User::with('profile');
        $qb->whereHas('roles', function($query){
            $query->where('slug', 'agent');
        });

        $agents = $qb->paginate(50);

        return view('admin.agents.index', [
            'agents' => $agents
        ]);
    }

    public function create()
    {
        $user = new User();
        $profile = new Profile();
        $user->profile = $profile;

        return view('admin.agents.create', [
            'agent' => $user
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
        $user->assignRole('agent');

        $profile = new Profile($request->input('profile'));
        $profile->user()->associate($user);

        if($request->hasFile('profile.profile_picture') && $request->file('profile.profile_picture')->isValid()){
            $profile->profile_picture = $profile->saveProfilePicture($request->file('profile.profile_picture'));
        }

        $profile->save();

        return redirect()->route('admin.agent.index')->with('messages', [$user->username.' has been created.']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user->load(['profile', 'profile.extendedProfile']);

        return view('admin.agents.edit', [
            'agent' => $user,
        ]);
    }

    public function update(UserFormRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->load(['profile', 'profile.extendedProfile']);

        //$user->username = $request->input('username');
        $user->status = $request->input('status');

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

        $user->push();

        return redirect($request->get('backUrl', route('admin.agent.index')))->with('messages', [$user->username.' has been updated.']);
    }

    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect($request->get('backUrl', route('admin.agent.index')))->with('messages', [$user->username.' has been deleted.']);
    }
}
