<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use GoProp\Http\Requests\Admin\AccountFormRequest;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function account_update()
    {
        $user = Auth::user();
        $user->load(['profile']);

        return view('admin.auth.account', [
            'user' => $user
        ]);
    }

    public function account_save(AccountFormRequest $request)
    {
        $user = Auth::user();
        $user->fill($request->all());
        $user->load(['profile']);

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

        return redirect()->back()->with('messages', ['Account is successfully updated.']);
    }
}
