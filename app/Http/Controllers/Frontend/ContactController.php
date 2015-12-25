<?php

namespace GoProp\Http\Controllers\Frontend;

use GoProp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function requestCall(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ];

        $this->validate($request, $rules);

        $messageVars = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ];

        Mail::send('frontend.emails.contact', $messageVars, function ($m){
            $m->to(config('app.contact_destination'))->subject('Contact Request');
        });

        if($request->ajax()){
            return response()->json([
                'message' => trans('contact.success_message')
            ]);
        }

        return redirect()->back()->with('messages', [trans('contact.success_message')]);
    }
}