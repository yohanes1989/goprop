<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard()
    {
        if(Auth::user()->backendAccess == 'portal'){
            return redirect()->route('portal.referrals.create');
        }

        return view('admin.dashboard');
    }
}
