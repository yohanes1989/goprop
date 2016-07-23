<?php

namespace GoProp\Http\Controllers\Portal\Auth;

use GoProp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $username = 'email';
    protected $loginPath;

    public function __construct()
    {
        $this->middleware('guest');

        $this->redirectTo = route('portal.dashboard');
    }

    public function getEmail()
    {
        return view('portal.auth.email');
    }

    public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));

            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    public function getReset(Request $request)
    {
        $token = $request->get('token', null);

        $email = DB::table('password_resets')->where('token', $token)->first();

        if (is_null($token) || !$email) {
            throw new NotFoundHttpException;
        }

        return view('portal.auth.reset')->with([
            'token' => $token,
            'email' => $email->email
        ]);
    }
}
