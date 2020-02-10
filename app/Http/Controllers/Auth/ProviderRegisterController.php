<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use App\Provider;

use DB, Auth, Validator, Exception;

class ProviderRegisterController extends Controller
{
    public function __construct() {

        $this->middleware('guest:provider');

    }

    public function showRegisterForm() {

      	return view('provider.auth.register');
    }


    public function register(Request $request) {

        try{

            DB::begintransaction();

          	$validator = Validator::make( $request->all(), [

          		  'name'=>'required|min:1|max:255',

          		  'email'=>'required|email|unique:providers,email',

          		  'password'=>'required|min:6|confirmed',
          	]);

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }

            $provider_details = New Provider;

            $provider_details->name = $request->name;
            
          	$provider_details->email = $request->email;

          	$provider_details->password = Hash::make($request->password);

            $provider_details->timezone = $request->timezone;
            
            if($provider_details->save()) {

                DB::commit();

                return redirect()->route('provider.login')->with(['profile'=>$provider_details, 'success'=>tr('provider_registered_successfully')]); 

            }

            throw new Exception(tr('provider_not_registered'), 1);
            

        }  catch (Exception $e) {
            
            DB::rollback();

            $error = $e->getMessage();

            return redirect()->back()->withInput()->with('error', $error);

        }
    }
}
