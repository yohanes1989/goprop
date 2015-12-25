<?php

namespace GoProp\Http\Controllers\Admin\Auth;

use GoProp\Http\Controllers\Frontend\Auth\AuthController as FrontAuthController;
use GoProp\Models\User;

class AuthController extends FrontAuthController
{
    protected $username = 'email';
    protected $loginPath;

    public function __construct()
    {
        $this->loginPath = action('Admin\Auth\AuthController@getLogin');
        $this->redirectTo = route('admin.dashboard');
        $this->redirectAfterLogout = action('Admin\Auth\AuthController@getLogin');
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

        return view('admin.auth.login');
    }
}
