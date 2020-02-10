<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;
use Password;

class ProviderResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/provider';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:provider');
    }

    public function showResetForm(Request $request, $token = null) {
        $email = $request->email;
        return view('provider.auth.passwords.reset')
            ->with(['token' => $token, 'email'=> $email]
            );
    }


    //defining which guard to use in our case, it's the admin guard
    protected function guard()
    {
        return Auth::guard('provider');
    }

    //defining our password broker function
    protected function broker() {
        return Password::broker('providers');
    }
}
