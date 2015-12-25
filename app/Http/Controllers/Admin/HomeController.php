<?php

namespace GoProp\Http\Controllers\Admin;

use GoProp\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
