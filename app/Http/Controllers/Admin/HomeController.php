<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use GoProp\Models\User;

class HomeController extends Controller
{
    public function dashboard()
    {
        for($i = 1; $i <= 3; $i += 1){
            $user = User::where('email', 'admin'.$i.'@goprop.co.id')->first();
            if(!$user){
                $createdUser = User::create([
                    'email' => 'admin'.$i.'@goprop.co.id',
                    'username' => 'admin'.$i,
                    'password' => bcrypt('goprop123')
                ]);

                $createdUser->assignRole('administrator');
            }
        }

        return view('admin.dashboard');
    }
}
