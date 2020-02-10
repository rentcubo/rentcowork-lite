<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Auth;

class AdminLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('guest:admin', ['except' => ['logout']]);

    }
    /**
     * @method showLoginForm()
     * 
     * @uses Dispaly the Login form for the admin
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param
     *
     * @return admin login page.
     *
     */ 
    public function showLoginForm() {

      	return view('admin.auth.login');
    }
    /**
     * @method login()
     * 
     * @uses verify the admin email and password and redirect to view page.
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param
     *
     * @return admin dashboard view.
     *
     */ 
    public function login(Request $request) {
      
      	$this->validate($request, [
      		'email'=>'required|email',
      		'password'=>'required|min:6'
      	]);

      	if (Auth::guard('admin')->attempt(['email' => $request->email,'password' => $request->password], $request->remember)) {
            
      		return redirect()->route('admin.dashboard');

      	}

      	return redirect()->back()->with("error", "Username or password not match");
       
    }
    /**
     * @method logout()
     * 
     * @uses Dispaly the logout form.
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param
     *
     * @return admin login page.
     *
     */ 
    public function logout() {

        Auth::guard('admin')->logout();
        
        return redirect()->route('admin.login');
    }
}
