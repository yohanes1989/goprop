<?php

namespace GoProp\Http\Controllers\Frontend;

use GoProp\Facades\SubscribeHelper;
use GoProp\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GoProp\Models\Page;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        if($request->isMethod('POST')){
            $rules = [
                'fullname' => 'required',
                'email' => 'required|email',
                'contact_number' => 'required',
                'message' => 'required|min:10',
            ];

            $this->validate($request, $rules);

            $messageVars = [
                'name' => $request->input('fullname'),
                'email' => $request->input('email'),
                'phone' => $request->input('contact_number'),
                'subject' => $request->input('subject'),
                'content' => $request->input('message'),
            ];

            SubscribeHelper::subscribe('website_database', $messageVars['email'], $messageVars['name'], null, ['phone' => $messageVars['phone']]);

            Mail::send('frontend.emails.contact', $messageVars, function ($m){
                $m->from(config('app.contact_from_email'), config('app.contact_from_name'));
                $m->to(config('app.contact_destination'))->subject('Inquiry Form');
            });

            return redirect()->refresh()->with('messages', [trans('contact.success_message')]);
        }

        $content = Page::where('identifier', 'contact')->first();

        return view('frontend.page.contact', [
            'content' => $content
        ]);
    }

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

        SubscribeHelper::subscribe('website_database', $messageVars['email'], $messageVars['name'], null, ['phone' => $messageVars['phone']]);

        Mail::send('frontend.emails.contact', $messageVars, function ($m){
            $m->from(config('app.contact_from_email'), config('app.contact_from_name'));
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