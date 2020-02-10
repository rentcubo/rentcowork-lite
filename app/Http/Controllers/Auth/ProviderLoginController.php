<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Auth\Authenticatable;

use Auth;


class ProviderLoginController extends Controller 
{
    public function __construct() {

        $this->middleware('guest:provider', ['except' => ['logout']]);

    }
      
    public function showLoginForm() {

      	return view('provider.auth.login');
    }

    public function login(Request $request) {

      	$this->validate($request, [

      		  'email'=>'required|email',

      		  'password'=>'required|min:6'
      	]);
        
      	if (Auth::guard('provider')->attempt(['email' => $request->email,'password' => $request->password,'status'=>APPROVED], $request->remember)) {

      		  return redirect()->intended(route('provider.dashboard'));

      	}

      	return redirect()->back()->with("error", tr('username_password_not_match'));
       
    }

    public function logout() {

        Auth::guard('provider')->logout();
        
        return redirect()->route('provider.login');
    }
}
