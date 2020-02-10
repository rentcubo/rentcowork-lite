<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Validator, Exception;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm() {

        try{

            if(setting()->get('is_email_enabled') != YES || envfile('MAIL_USERNAME') == "" || envfile('MAIL_PASSWORD') == "" ) {

                throw new Exception(tr('email_not_configured_admin'), 1);
                
            }

            return view('auth.passwords.email');

        } catch(Exception $e){ 

            $error = $e->getMessage();

            return redirect()->route('login')->with('error', $error);

        } 
    }
}
