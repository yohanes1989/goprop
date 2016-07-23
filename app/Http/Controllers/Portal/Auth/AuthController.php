<?php

namespace GoProp\Http\Controllers\Portal\Auth;

use GoProp\Http\Controllers\Admin\Auth\AuthController as AdminAuthController;
use GoProp\Models\User;

class AuthController extends AdminAuthController
{
    public function __construct()
    {
        $this->loginPath = action('Portal\Auth\AuthController@getLogin');
        $this->redirectTo = route('portal.dashboard');
        $this->redirectAfterLogout = action('Portal\Auth\AuthController@getLogin');
    }

    public function getLogin()
    {
        /*
        $admin = new User();
        $admin->username = 'admin';
        $admin->email = 'owner@goprop.co.id';
        $admin->password = bcrypt('goprop123');
        $admin->save();

        $admin->assignRole('administrator');
        */

        return view('portal.auth.login');
    }
}
