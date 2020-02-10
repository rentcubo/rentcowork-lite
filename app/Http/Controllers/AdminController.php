<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use  DB, Hash, Setting, Auth, Validator, Exception, Enveditor, File, Log;

use App\Settings;

use App\Helpers\Helper;

use App\Helpers\ViewHelper;

use App\Helpers\EnvEditorHelper;

use App\Admin;

use App\User;

use App\StaticPage;

use App\Provider;

use App\Space;

use App\Booking;

use App\BookingProviderReview;

use App\BookingUserReview;

use App\BookingPayment;

class AdminController extends Controller
{   
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');  
        
    }
    /**
     * @method dashboard()
     * 
     * @uses Dispaly the Login form for the admin
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param
     *
     * @return dashboard view page.
     *
     */ 
    public function dashboard(){

        $dashboard_data = [];

        $dashboard_data['users'] = User::count();

        $dashboard_data['providers'] = Provider::count();

        $dashboard_data['bookings'] = Booking::count();

        $dashboard_data['revenue'] =  BookingPayment::where('status', PAID)->sum('booking_payments.total');

        $recent_users= User::orderBy('updated_at' , 'desc')->skip(0)->take(6)->get();

        $recent_providers= Provider::orderBy('updated_at' , 'desc')->skip(0)->take(6)->get(); 

        $recent_bookings = Booking::orderBy('updated_at' , 'desc')->skip(0)->take(6)->get();

        $data = json_decode(json_encode($dashboard_data));

        return view('admin.dashboard')
            ->with('page','dashboard')
            ->with('data',$data)
            ->with('recent_users',$recent_users)
            ->with('recent_providers',$recent_providers);
    }

     /**
     *
     * User Module Functions
     */
     /**
     * @method users_index()
     *
     * @uses To list out users details 
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param 
     * 
     * @return return view page
     *
     */
    public function users_index() {

        $users = User::orderBy('updated_at','desc')->paginate(10);

        return view('admin.users.index')
                    ->with('page','users')
                    ->with('sub_page' , 'users-view')
                    ->with('users' , $users);
    }

    /**
     * @method users_create()
     *
     * @uses To create user details
     *
     * @created  Akshata
     *
     * @updated 
     *
     * @param 
     * 
     * @return return view page
     *
     */
    public function users_create() {

        $user_details = new User;

        return view('admin.users.create')
                    ->with('page' , 'users')
                    ->with('sub_page','users-create')
                    ->with('user_details', $user_details);           
    }

    /**
     * @method users_edit()
     *
     * @uses To display and update user details based on the user id
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param Object Request
     * 
     * @return redirect view page 
     *
     */
    public function users_edit(Request $request) {

        try {

            $user_details = User::find($request->user_id);

            if(!$user_details) { 

                throw new Exception(tr('user_not_found'), 101);
            }

            return view('admin.users.edit')
                    ->with('page' , 'users')
                    ->with('sub_page','users-view')
                    ->with('user_details' , $user_details); 
            
        } catch(Exception $e) {

            $error = $e->getMessage();

            return redirect()->route('admin.users.index')->with('flash_error' , $error);
        }
    
    }

    /**
     * @method users_save()
     *
     * @uses To save the users details of new/existing user object based on details
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param object request - User Form Data
     *
     * @return index or view page
     *
     */
    public function users_save(Request $request) {

        try {

            DB::begintransaction();

            $validator = Validator::make( $request->all(), [
                'first_name' => 'required|max:191',
                'last_name' => 'required|max:191',
                'email' => $request->user_id ? 'required|email|max:191|unique:users,email,'.$request->user_id.',id' : 'required|email|max:191|unique:users,email,NULL,id',
                'password' => $request->user_id ? "" : 'required|min:6',
                'mobile' =>  'digits_between:6,13|nullable',
                'picture' => 'mimes:jpg,jpeg|nullable',
                'description' => 'max:191',
                'user_id' => 'exists:users,id'
                ]
            );

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);

            }

            $user_details = $request->user_id ? User::find($request->user_id) : new User;

            $is_new_user = NO;

            if($user_details->id) {

                $message = tr('user_updated_success'); 

            } else {

                $is_new_user = YES;

                $user_details->password = ($request->password) ? \Hash::make($request->password) : null;

                $message = tr('user_created_success');

                $user_details->email_verified_at = date('Y-m-d H:i:s');

                $user_details->picture = asset('placeholder.jpg');

                $user_details->is_verified = USER_EMAIL_VERIFIED;

                $user_details->status = APPROVED;

            }

            $user_details->first_name = $request->first_name ?: $user_details->first_name;

            $user_details->last_name = $request->last_name ?: $user_details->last_name;

            $user_details->name = $user_details->first_name.' '.$user_details->last_name;

            $user_details->email = $request->email ?: $user_details->email;

            $user_details->mobile = $request->mobile ?: '';

            $user_details->description = $request->description ?: '';

            $user_details->login_by = $request->login_by ?: 'manual';

            // Upload picture
            
            if($request->hasFile('picture')) {

                if($request->user_id) {

                    Helper::delete_file($user_details->picture, PROFILE_PATH_USER); 
                    // Delete the old pic
                }

                $user_details->picture = Helper::upload_file($request->file('picture'), PROFILE_PATH_USER);
            }
            
            if($user_details->save()) {

                if($is_new_user == YES) {

                    $user_details->is_verified = USER_EMAIL_VERIFIED;

                    $user_details->save();

                }
                    
                DB::commit(); 

                return redirect()->route('admin.users.view', ['user_id' => $user_details->id])->with('flash_success', $message);

            } 

            throw new Exception(tr('user_save_failed'));
            
        } catch(Exception $e){ 

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->back()->withInput()->with('flash_error', $error);

        } 

    }

    /**
     * @method users_view()
     *
     * @uses view the users details based on users id
     *
     * @created Akshata 
     *
     * @updated 
     *
     * @param Obeject $request -User Id
     * 
     * @return View page
     *
     */
    public function users_view(Request $request) {
       
        try {
      
            $user_details = User::find($request->user_id);

            if(!$user_details) { 

                throw new Exception(tr('user_not_found'), 101);                
            }           
                 
            return view('admin.users.view')
                        ->with('page', 'users') 
                        ->with('sub_page','users-view') 
                        ->with('user_details' , $user_details);

            
        } catch (Exception $e) {

            $error = $e->getMessage();

            return redirect()->back()->with('flash_error', $error);
        }
    
    }

    /**
     * @method users_delete()
     *
     * @uses delete the user details based on user id
     *
     * @created Akshata
     *
     * @updated  
     *
     * @param object $request - User Id
     * 
     * @return response of success/failure details with view page
     *
     */
    public function users_delete(Request $request) {

        try {

            DB::begintransaction();

            $user_details = User::find($request->user_id);
            
            if(!$user_details) {

                throw new Exception(tr('user_not_found'), 101);                
            }

            if($user_details->delete()) {

                DB::commit();

                return redirect()->route('admin.users.index')->with('flash_success',tr('user_deleted_success'));   

            } 
            
            throw new Exception(tr('user_delete_failed'));
            
        } catch(Exception $e){

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->back()->with('flash_error', $error);

        }       
         
    }

    /**
     * @method users_status
     *
     * @uses To update user status as DECLINED/APPROVED based on users id
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param object $request - User Id
     * 
     * @return response success/failure message
     *
     **/
    public function users_status(Request $request) {

        try {

            DB::beginTransaction();

            $user_details = User::find($request->user_id);

            if(!$user_details) {

                throw new Exception(tr('user_not_found'), 101);
                
            }

            $user_details->status = $user_details->status ? DECLINED : APPROVED ;

            if($user_details->save()) {

                DB::commit();

                $message = $user_details->status ? tr('user_approve_success') : tr('user_decline_success');

                return redirect()->back()->with('flash_success', $message);
            }
            
            throw new Exception(tr('user_status_change_failed'));

        } catch(Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->route('admin.users.index')->with('flash_error', $error);

        }

    }

     /**
     *
     * Provider Module Functions
     */

     /**
     * @method providers_index
     *
     * @uses Get the providers list
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param 
     * 
     * @return view page
     *
     */
    public function providers_index() {

        $providers = Provider::orderBy('updated_at','desc')->paginate(10);

        return view('admin.providers.index')
                    ->with('page' , 'providers')
                    ->with('sub_page','providers-view')
                    ->with('providers' , $providers);

    }

    /**
     * @method providers_create
     *
     * @uses To create providers details
     *
     * @created Akshata
     *
     * @updated  
     *
     * @param 
     * 
     * @return view page
     *
     */
    public function  providers_create() {

        $provider_details = new Provider;

        return view('admin.providers.create')
                    ->with('page' , 'providers')
                    ->with('sub_page','providers-create')
                    ->with('provider_details', $provider_details);
    
    }

    /**
     * @method providers_edit()
     *
     * @uses To display and update provider details based on the provider id
     *
     * @created Akshata
     *
     * @updated  
     *
     * @param object $request - provider Id
     * 
     * @return redirect view page 
     *
     */    
    public function providers_edit(Request $request) {

        try {
      
            $provider_details = Provider::find($request->provider_id);

            if(!$provider_details) {

                throw new Exception(tr('provider_not_found'), 101);
                
            }
           
            return view('admin.providers.edit')
                        ->with('page', 'providers')
                        ->with('sub_page', 'providers-view')
                        ->with('provider_details', $provider_details);
            
        } catch (Exception $e) {

            $error = $e->getMessage();

            return redirect()->back()->with('flash_error', $error);
        }
    
    }

    /**
     * @method providers_save
     *
     * @uses To save the providers details of new/existing provider object based on details
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param object $request - providers object details
     * 
     * @return response of success/failure response details
     *
     */
    public function providers_save(Request $request) {

       try {
            
            DB::begintransaction();
            
            $validator = Validator::make( $request->all(), [
                'name' => 'required|max:191',
                'email' => $request->provider_id ? 'required|email|max:191|unique:providers,email,'.$request->provider_id.',id' : 'required|email|max:191|unique:providers,email,NULL,id',
                'password' => $request->provider_id ? "" : 'required|min:6',
                'mobile' => 'required|digits_between:6,13',
                'picture' => $request->provider_id ? "mimes:jpg,jpeg" : 'required|mimes:jpg,jpeg',
                'description' => 'max:191'
                ]
            );

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);

            }

            $providers_details = $request->provider_id ? Provider::find($request->provider_id) : new Provider;

            $new_user = NO;

            if($providers_details->id) {

                $message = tr('provider_updated_success'); 

            } else {

                $new_user = YES;

                $message = tr('provider_created_success');

                $providers_details->password = ($request->password) ? \Hash::make($request->password) : null;

                $providers_details->email_verified_at = date('Y-m-d H:i:s');

                $providers_details->picture = asset('placeholder.jpg');

            }

            $providers_details->name = $request->has('name') ? $request->name: $providers_details->name;

            $providers_details->email = $request->has('email') ? $request->email: $providers_details->email;
            
            $providers_details->mobile =  $request->mobile ?? "";

            $providers_details->description = $request->description ?? "";
            
            // Upload picture

            if($request->hasFile('picture') ) {

                if($request->provider_id) {

                    Helper::delete_file($providers_details->picture, PROFILE_PATH_PROVIDER); 
                    // Delete the old pic
                }

                $providers_details->picture = Helper::upload_file($request->file('picture'), PROFILE_PATH_PROVIDER);
            }

            if($providers_details->save()) {
                
                DB::commit(); 

                return redirect()->route('admin.providers.view', ['provider_id' => $providers_details->id])->with('flash_success', $message);

            } 

            throw new Exception(tr('provider_save_failed'));
            
        } catch(Exception $e){ 

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->back()->withInput()->with('flash_error', $error);

        }   
        
    }

    /**
     * @method providers_view
     *
     * @uses view the selected provider details 
     *
     * @created Akshata
     *
     * @updated
     *
     * @param Integer $request - provider id
     * 
     * @return view page
     *
     **/
    public function providers_view(Request $request) {
        try{
            $provider_details = Provider::find($request->provider_id);

            if(!$provider_details) {

                throw new Exception(tr('provider_not_found'), 101);
                
            }

            return view('admin.providers.view')
                        ->with('page', 'providers')
                        ->with('sub_page','providers-view')
                        ->with('provider_details' , $provider_details);
        } catch(Exception $e){

            $error = $e->getMessage();

            return redirect()->back()->with('flash_error',$error);
        }  
    }

    /**
     * @method providers_delete
     *
     * @uses To delete the providers details based on selected provider id
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param Integer $request - provider id
     * 
     * @return response of success/failure details
     *
     **/
    public function providers_delete(Request $request) {

        try {

            DB::beginTransaction();

            $provider_details = provider::find($request->provider_id);

            if(!$provider_details) {

                throw new Exception(tr('provider_not_found'), 101);
                
            }

            if($provider_details->delete()) {

                DB::commit();

                return redirect()->route('admin.providers.index')->with('flash_success',tr('provider_delete_success')); 
            } 
            
            throw new Exception(tr('provider_delete_failed'));

        } catch(Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->route('admin.providers.index')->with('flash_error', $error);

        }
   
    }

    /**
     * @method providers_status
     *
     * @uses To update provider status as DECLINED/APPROVED based on provide id
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param Integer $request - provider id
     * 
     * @return response success/failure message
     *
     **/
    public function providers_status(Request $request) {

        try {

            DB::beginTransaction();

            $provider_details = Provider::find($request->provider_id);

            if(!$provider_details) {

                throw new Exception(tr('provider_not_found'), 101);
                
            }

            $provider_details->status = $provider_details->status ? DECLINED : APPROVED;

            if( $provider_details->save()) {

                DB::commit();

                $message = $provider_details->status ? tr('provider_approve_success') : tr('provider_decline_success');

                return redirect()->back()->with('flash_success', $message);
            }

            throw new Exception(tr('provider_status_change_failed'), 101);

        } catch(Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->route('admin.providers.index')->with('flash_error', $error);

        }

    }
    /**
    *
    * Space module functions
    *
    **/
    /**
     * @method spaces_create()
     *
     * @uses  Display form to create a space details
     *
     * @created Akshata
     *
     * @updated
     *
     * @param 
     *
     * @return view page 
     */
    public function spaces_index() {

        $spaces = Space::orderBy('created_at','DESC')->paginate(10);

        return view('admin.spaces.index')
                ->with('page','spaces')
                ->with('sub_page','spaces-view')
                ->with('spaces',$spaces);
    }
    /**
     * @method spaces_create()
     *
     * @uses  Display form to create a space details
     *
     * @created Akshata
     *
     * @updated
     *
     * @param 
     *
     * @return view page 
     */
    public function spaces_create() {

        $space_details = New Space;

        $providers = Provider::where('status',APPROVED)->get();

        return view('admin.spaces.create')
                ->with('page','spaces')
                ->with('sub_page','spaces-create')
                ->with('space_details',$space_details)
                ->with('providers',$providers);
    }

    /**
     * @method spaces_edit()
     *
     * @uses  Used to edit the space details
     *
     * @created Akshata
     *
     * @updated
     *
     * @param 
     *
     * @return view page 
     */
    public function spaces_edit(Request $request) {
        try {
        
            $space_details = Space::find($request->space_id);

            $providers = Provider::where('status',APPROVED)->get();

            foreach ($providers as $key => $provider_details) {
                
                $provider_details->is_selected = $space_details->provider_id == $provider_details->id ? YES : NO;
            }
            if(!$space_details) {

                throw new Exception(tr('space_not_found'),101);
                
            }
            return view('admin.spaces.edit')
                    ->with('page','spaces')
                    ->with('sub_page','spaces-create')
                    ->with('space_details',$space_details)
                    ->with('providers',$providers);

        } catch(Exception $e) {

            $error =  $e->getMessage();

            return redirect()->back()->with('flash_error',$error);
        }
    }
    /**
     * @method spaces_save()
     *
     * @uses  Save the space details to the database.
     *
     * @created Akshata
     *
     * @updated
     *
     * @param Object Request - spaces details
     *
     * @return view page 
     */
    public function spaces_save(Request $request) {

        try {
    
            DB::begintransaction();
            
            $validator = Validator::make( $request->all(), [
                'provider_id' => 'required',
                'name' => 'required|max:255',
                'tagline' => 'required|max:255',
                'full_address' => 'required|max:255',
                'instructions' => 'required|max:255',
                'picture' => 'mimes:jpg,jpeg|nullable',
                'per_hour' => 'required|numeric|max:100000|min:0',
                'description' => 'max:191',
                ]
            );

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);

            }

            $space_details = $request->space_id ? Space::find($request->space_id) : new Space;

            if($space_details->id) {

                $message = tr('space_updated_success'); 

            } else {

                $message = tr('space_created_success');

                $space_details->picture = asset('space-placeholder.jpg');

                $space_details->admin_status = ADMIN_SPACE_APPROVED;

                $space_details->uploaded_by = ADMIN;

            }
            $space_details->provider_id = $request->provider_id ?: $space_details->provider_id;

            $space_details->name =  $request->name ?: $space_details->name;

            $space_details->tagline = $request->tagline ?: $space_details->tagline;
            
            $space_details->full_address =  $request->full_address ?: $space_details->full_address;

            $space_details->instructions =  $request->instructions ?: $space_details->instructions;

            $space_details->description = $request->description ?? "";

            $space_details->per_hour = $request->per_hour ?: $space_details->per_hour;
            
            // Upload picture

            if($request->hasFile('picture') ) {

                if($request->space_id) {

                    Helper::delete_file($space_details->picture, PROFILE_PATH_SPACES); 
                    // Delete the old pic
                }

                $space_details->picture = Helper::upload_file($request->file('picture'), PROFILE_PATH_SPACES);
            }

            if($space_details->save()) {
                
                DB::commit(); 

                return redirect()->route('admin.spaces.view', ['space_id' => $space_details->id])->with('flash_success', $message);

            } 

            throw new Exception(tr('space_save_failed'));
            
        } catch(Exception $e){ 

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->back()->withInput()->with('flash_error', $error);

        }  
    }
    /**
     * @method spaces_view()
     *
     * @uses  Shows the spacified details of the space
     *
     * @created Akshata
     *
     * @updated
     *
     * @param Object Request - Space_id
     *
     * @return view page 
     */
    public function spaces_view(Request $request) {

        try{
            $space_details = Space::find($request->space_id);

            if(!$space_details) {

                throw new Exception(tr('space_not_found'), 101);
                
            }
            return view('admin.spaces.view')
                        ->with('page', 'spaces')
                        ->with('sub_page','spaces-view')
                        ->with('space_details' , $space_details);
        } catch(Exception $e){

            $error = $e->getMessage();

            return redirect()->back()->with('flash_error',$error);
        }
    }

    /**
     * @method spaces_delete()
     *
     * @uses  Delete the spacified details of the space
     *
     * @created Akshata
     *
     * @updated
     *
     * @param Object Request - Space_id
     *
     * @return view page 
     */
    public function spaces_delete(Request $request) {
        try {

            DB::beginTransaction();

            $space_details = Space::find($request->space_id);

            if(!$space_details) {

                throw new Exception(tr('space_not_found'), 101);
                
            }

            if($space_details->delete()) {

                DB::commit();

                return redirect()->route('admin.spaces.index')->with('flash_success',tr('space_delete_success')); 
            } 
            
            throw new Exception(tr('space_delete_failed'));

        } catch(Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->route('admin.spaces.index')->with('flash_error', $error);

        } 
    }

    /**
     * @method spaces_status()
     *
     * @uses  To update space status as DECLINED/APPROVED based on space id
     *
     * @created Akshata
     *
     * @updated
     *
     * @param Object Request - Space_id
     *
     * @return view page 
     */
    public function spaces_status(Request $request) {
        try {

            DB::beginTransaction();

            $space_details = Space::find($request->space_id);

            if(!$space_details) {

                throw new Exception(tr('space_not_found'), 101);
                
            }

            $space_details->admin_status = $space_details->admin_status ? SPACE_DECLINED : SPACE_APPROVED;

            if( $space_details->save()) {

                DB::commit();

                $message = $space_details->admin_status ? tr('space_approve_success') : tr('space_decline_success');

                return redirect()->back()->with('flash_success', $message);
            }

            throw new Exception(tr('space_status_change_failed'), 101);

        } catch(Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->route('admin.providers.index')->with('flash_error', $error);

        }
    }

    /**
     * @method bookings_index()
     *
     * @uses To list out bookings details 
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param 
     * 
     * @return return view page
     *
     */
    public function bookings_index(Request $request) {

        try{

            $base_query = Booking::orderBy('updated_at','desc');

            if($request->user_id) {

                $user_details = User::find($request->user_id);

                if(!$user_details) {

                    throw new Exception(tr('user_not_found'), 101);
                    
                }

                $base_query = $base_query->where('bookings.user_id','=', $request->user_id);

            }

            $bookings = $base_query->paginate(10);

            return view('admin.bookings.index')
                ->with('page','bookings')
                ->with('sub_page' , 'bookings-view')
                ->with('bookings' , $bookings);

        } catch(Exception $e) {

            $error = $e->getMessage();

            return redirect()->back()->with('flash_error',$error);
        }

    }

    /**
     * @method bookings_view()
     *
     * @uses view the bookings details based on bookings id
     *
     * @created Akshata 
     *
     * @updated 
     *
     * @param object $request - booking Id
     * 
     * @return View page
     *
     */
    public function bookings_view(Request $request) {
        
        try {

            $booking_details = Booking::find($request->booking_id);

            if(!$booking_details) {

                throw new Exception(tr('booking_not_found'), 101);   
            }
            $booking_payment_details =  BookingPayment::where('booking_id','=',$booking_details->id)->first() ?:  new BookingPayment;

            if(!$booking_payment_details) {

                throw new Exception(tr('payment_details_not_found'), 101);
                
            }
            return view('admin.bookings.view')
                    ->with('page', 'bookings')
                    ->with('sub_page' ,'')
                    ->with('booking_details',$booking_details)
                    ->with('booking_payment_details',$booking_payment_details);

        } catch (Exception $e) {

            $error = $e->getMessage();

            return back()->with('flash_error', $error);

        }
    }
     /**
     * @method bookings_payments()
     *
     * @uses To display bookings payments
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param 
     *
     * @return
     *
     **/
    public function bookings_payments(Request $request) {
        
        $base_query = BookingPayment::orderBy('created_at','DESC');

        if($request->user_id) {
                       
            $base_query = $base_query->where('booking_payments.user_id',$request->user_id);
        }        

        if($request->space_id) {
                       
            $base_query = $base_query->where('booking_payments.space_id',$request->space_id);
        }      

        if($request->provider_id) {
                       
            $base_query = $base_query->where('booking_payments.provider_id',$request->provider_id);
        } 

        $booking_payments = $base_query->paginate(10);

        return view('admin.revenues.booking_payment')
                ->with('page', 'revenue')
                ->with('sub_page' ,'')
                ->with('booking_payments',$booking_payments);
    }

    /**
     * @method bookings_payments_view()
     *
     * @uses To display specified booking details
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param 
     *
     * @return
     *
     **/
    public function bookings_payments_view(Request $request){

        $booking_payment_details = BookingPayment::find($request->payment_id);

        if(!$booking_payment_details){

            throw new Exception(tr('payment_details_not_found'), 101);
            
        }

        return view('admin.revenues.booking_payment_view')
                ->with('page','revenue')
                ->with('booking_payment_details',$booking_payment_details);
    }
    /**
     * @method providers_review()
     *
     * @uses To list out provider review details 
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param request $provider_id
     * 
     * @return return view page
     *
     */
    public function providers_review(Request $request) {

        $base_query = BookingProviderReview::orderBy('created_at','DESC');

        if($request->provider_id) {
                       
            $base_query = $base_query->where('booking_provider_reviews.provider_id','=',$request->provider_id);
        }  
            
        $provider_reviews = $base_query->paginate(10);
        
        return view('admin.reviews.index')
                ->with('page', 'reviews')
                ->with('sub_page' , 'providers-review')
                ->with('reviews', $provider_reviews);
    }

    /**
     * @method users_review()
     *
     * @uses To list out user review details 
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param request $user_id
     * 
     * @return return view page
     *
     */
    public function users_review(Request $request) {

        $base_query = BookingUserReview::orderBy('created_at','DESC');

        if($request->user_id) {
                       
            $base_query = $base_query->where('booking_user_reviews.user_id',$request->user_id);
        }  

        $user_reviews = $base_query->paginate(10);
        
        return view('admin.reviews.index')
                ->with('page', 'reviews')
                ->with('sub_page' , 'users-review')
                ->with('reviews', $user_reviews);
    }
     /**
     * @method profile()
     *
     * @uses  Used to display the logged in admin details
     *
     * @created Akshata
     *
     * @updated
     *
     * @param 
     *
     * @return view page 
     */

    public function profile() {

        return view('admin.account.profile')
                ->with('page', 'dashboard')
                ->with('sub_page' , 'profile');

    }

    /**
     * @method profile_save()
     *
     * @uses Used to update the admin details
     *
     * @created Akshata
     *
     * @updated
     *
     * @param -
     *
     * @return view page 
     */

    public function profile_save(Request $request) {

        try {

            DB::beginTransaction();

            $validator = Validator::make( $request->all(), [
                    'name' => 'max:191',
                    'email' => $request->admin_id ? 'email|max:191|unique:admins,email,'.$request->admin_id : 'email|max:191|unique:admins,email,NULL',
                    'admin_id' => 'required|exists:admins,id',
                    'picture' => '',
                ]
            );
            
            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
                
            }

            $admin_details = Admin::find($request->admin_id);

            if(!$admin_details) {

                Auth::guard('admin')->logout();

                throw new Exception(tr('admin_details_not_found'), 101);

            }
            
            $admin_details->name = $request->name ?: $admin_details->name;

            $admin_details->email = $request->email ?: $admin_details->email;

            if($request->hasFile('picture') ) {

                Helper::delete_file($admin_details->picture, PROFILE_PATH_ADMIN); 
                
                $admin_details->picture = Helper::upload_file($request->file('picture'), PROFILE_PATH_ADMIN);
            }
            
            $admin_details->remember_token = Helper::generate_token();

            $admin_details->timezone = $request->timezone ?: $admin_details->timezone;

            $admin_details->save();

            DB::commit();

            return redirect()->route('admin.profile')->with('flash_success', tr('admin_profile_success'));


        } catch(Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->back()->withInput()->with('flash_error' , $error);

        }    
    
    }

    /**
     * @method change_password()
     *
     * @uses  Used to change the admin password
     *
     * @created Akshata
     *
     * @updated
     *
     * @param 
     *
     * @return view page 
     */

    public function change_password(Request $request) {

        try {

            DB::begintransaction();

            $validator = Validator::make($request->all(), [              
                'password' => 'required|confirmed|min:6',
                'old_password' => 'required',
            ]);
            
            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
                
            }

            $admin_details = Admin::find(Auth::guard('admin')->user()->id);

            if(!$admin_details) {

                Auth::guard('admin')->logout();
                              
                throw new Exception(tr('admin_details_not_found'), 101);

            }

            if(Hash::check($request->old_password,$admin_details->password)) {

                $admin_details->password = Hash::make($request->password);

                $admin_details->save();

                DB::commit();

                Auth::guard('admin')->logout();

                // return back()->with('flash_success', tr('password_change_success'));
                return redirect()->route('admin.login');
                
            } else {

                throw new Exception(tr('password_mismatch'));
            }

        } catch(Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->back()->withInput()->with('flash_error' , $error);

        }    
    
    }
    /**
     * @method settings()
     * 
     * @uses To display settings details
     *
     * @created Akshata 
     *
     * @updated 
     *
     * @param - 
     *
     * @return success/error message
     */   
    public function settings() {

        $settings = array();

        $result = EnvEditorHelper::getEnvValues();

        return view('admin.settings')
                ->with('page','settings')
                ->with('sub_page','')
                ->with('settings' , $settings)
                ->with('result', $result); 
    
    }

      /**
     * @method settings_save()
     * 
     * @uses to update settings details
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param (request) setting details
     *
     * @return success/error message
     */
    public function settings_save(Request $request) {
        try {
            
            DB::beginTransaction();
            
            $validator = Validator::make($request->all() , 
                [
                    'site_logo' => 'mimes:jpeg,jpg,bmp,png',
                    'site_icon' => 'mimes:jpeg,jpg,bmp,png',

                ],
                [
                    'mimes' => tr('image_error')
                ]
            );

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }

            foreach( $request->toArray() as $key => $value) {

                if($key != '_token') {

                    $check_settings = Settings::where('key' ,'=', $key)->count();

                    if( $check_settings == 0 ) {

                        throw new Exception( $key.tr('settings_key_not_found'), 101);
                    }
                    
                    if( $request->hasFile($key) ) {
                                            
                        $file = Settings::where('key' ,'=', $key)->first();
                       
                        Helper::delete_file($file->value, FILE_PATH_SITE);

                        $file_path = Helper::upload_file($request->file($key) , FILE_PATH_SITE);    

                        $result = Settings::where('key' ,'=', $key)->update(['value' => $file_path]); 

                        if( $result == TRUE ) {
                     
                            DB::commit();
                   
                        } else {

                            throw new Exception(tr('settings_save_error'), 101);
                        } 
                   
                    } else {
                    
                        $result = Settings::where('key' ,'=', $key)->update(['value' => $value]);  
                    
                        if( $result == TRUE ) {
                         
                            DB::commit();
                       
                        } else {

                            throw new Exception(tr('settings_save_error'), 101);
                        } 

                    }  
 
                }
            }

            Helper::settings_generate_json();

            return back()->with('flash_success', tr('settings_update_success'));
            
        } catch (Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return back()->with('flash_error', $error);
        
        }
    }

    /**
     * @method common_settings_save()
     * 
     * @uses to update settings details
     *
     * @created Akshata
     *
     * @updated 
     *
     * @param
     *
     * @return success/error message
     */
    public function common_settings_save(Request $request) {

        try {

            $settings = array();

            $admin_id = \Auth::guard('admin')->user()->id;

            // dd($request->all());

            foreach($request->all() as $key => $data ) {

                Log::info("Key".$key);
            }



            foreach($request->all() as $key => $data ) {

                Log::info($key);
                Log::info($data);

                if( \Enveditor::set($key, $data)) { 

                    // dd("ddjjdjdjd");
        
                    // do nothing on success update
                    
                } else {

                    $result = Settings::where('key' ,'=', $key)->update(['value' => $data]); 

                    if($result == TRUE) {
                     
                        DB::commit();
                   
                    } else {

                        // throw new Exception(tr('admin_settings_save_error'), 101);
                    }     
                }
            }

            return redirect()->route('clear-cache')->with('setting', $settings);
            
        } catch (Exception $e) {
            
            $error = $e->getMessage();

            return back()->with('flash_error', $error);
        }

    }
    /**
    *
    * Static page module function
    *
    **/
    /**
     * @method static_pages_index()
     *
     * @uses Used to list the static pages
     *
     * @created vithya
     *
     * @updated vithya  
     *
     * @param -
     *
     * @return List of pages   
     */

    public function static_pages_index() {

        $static_pages = StaticPage::orderBy('updated_at' , 'desc')->get();

        return view('admin.static_pages.index')
                    ->with('page','static_pages')
                    ->with('sub_page',"static_pages_view")
                    ->with('static_pages',$static_pages);
    
    }

    /**
     * @method static_pages_create()
     *
     * @uses To create static_page details
     *
     * @created vithya
     *
     * @updated Anjana   
     *
     * @param
     *
     * @return view page   
     *
     */
    public function static_pages_create() {

        $static_keys = ['about' , 'contact' , 'privacy' , 'terms' , 'help' , 'faq' , 'refund', 'cancellation'];

        foreach ($static_keys as $key => $static_key) {

            // Check the record exists

            $check_page = StaticPage::where('type', $static_key)->first();

            if($check_page) {
                unset($static_keys[$key]);
            }
        }

        $static_keys[] = 'others';

        $static_page_details = new StaticPage;

        return view('admin.static_pages.create')
                ->with('page','static_pages')
                ->with('sub_page',"static_pages_create")
                ->with('static_keys', $static_keys)
                ->with('static_page_details',$static_page_details);
   
    }

    /**
     * @method static_pages_edit()
     *
     * @uses To display and update static_page details based on the static_page id
     *
     * @created Anjana
     *
     * @updated vithya
     *
     * @param object $request - static_page Id
     * 
     * @return redirect view page 
     *
     */
    public function static_pages_edit(Request $request) {

        try {

            $static_page_details = StaticPage::find($request->static_page_id);

            if(!$static_page_details) {

                throw new Exception(tr('static_page_not_found'), 101);
            }

            $static_keys = ['about' , 'contact' , 'privacy' , 'terms' , 'help' , 'faq' , 'refund', 'cancellation'];

            $static_keys[] = 'others';

            $static_keys[] = $static_page_details->type;

            return view('admin.static_pages.edit')
                    ->with('page' , 'static_pages')
                    ->with('sub_page','static_pages_view')
                    ->with('static_keys' , array_unique($static_keys))
                    ->with('static_page_details' , $static_page_details);
            
        } catch(Exception $e) {

            $error = $e->getMessage();

            return redirect()->route('admin.static_pages.index')->with('flash_error' , $error);

        }
    }

    /**
     * @method static_pages_save()
     *
     * @uses Used to create/update the page details 
     *
     * @created vithya
     *
     * @updated vithya
     *
     * @param
     *
     * @return index page    
     *
     */
    public function static_pages_save(Request $request) {

        try {

            DB::beginTransaction();

            $validator = Validator::make( $request->all(), [
                    'title' => $request->static_page_id ? 'required|max:191|unique:static_pages,title,'.$request->static_page_id.',id' : 'required|max:191|unique:static_pages,title,NULL,id',
                    'description' => 'required',
                    'type' => !$request->static_page_id ? 'required' : ""
                ]
            );
                   
            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
                
            }

            if($request->static_page_id != '') {

                $static_page_details = StaticPage::find($request->static_page_id);

                $message = tr('static_page_updated_success');                    

            } else {

                $check_page = "";

                // Check the staic page already exists

                if($request->type != 'others') {

                    $check_page = StaticPage::where('type',$request->type)->first();

                    if($check_page) {

                        return back()->with('flash_error',tr('static_page_already_alert'));
                    }

                }

                $message = tr('static_page_created_success');

                $static_page_details = new StaticPage;

                $static_page_details->status = APPROVED;

            }

            $static_page_details->title = $request->title ?: $static_page_details->title;

            $static_page_details->description = $request->description ?: $static_page_details->description;

            $static_page_details->type = $request->type ?: $static_page_details->type;

            $static_page_details->section_type = $request->section_type ?: $static_page_details->section_type;

            if($static_page_details->save()) {

                DB::commit();

                return redirect()->route('admin.static_pages.view', ['static_page_id' => $static_page_details->id] )->with('flash_success', $message);

            } 

            throw new Exception(tr('static_page_save_failed'), 101);
                      
        } catch(Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return back()->withInput()->with('flash_error', $error);

        }
    
    }

    /**
     * @method static_pages_delete()
     *
     * Used to view file of the create the static page 
     *
     * @created vithya
     *
     * @updated vithya R
     *
     * @param -
     *
     * @return view page   
     */

    public function static_pages_delete(Request $request) {

        try {

            DB::beginTransaction();

            $static_page_details = StaticPage::find($request->static_page_id);

            if(!$static_page_details) {

                throw new Exception(tr('static_page_not_found'), 101);
                
            }

            if($static_page_details->delete()) {

                DB::commit();

                return redirect()->route('admin.static_pages.index')->with('flash_success',tr('static_page_deleted_success')); 

            } 

            throw new Exception(tr('static_page_error'));

        } catch(Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->route('admin.static_pages.index')->with('flash_error', $error);

        }
    
    }

    /**
     * @method static_pages_view()
     *
     * @uses view the static_pages details based on static_pages id
     *
     * @created Anjana 
     *
     * @updated vithya
     *
     * @param object $request - static_page Id
     * 
     * @return View page
     *
     */
    public function static_pages_view(Request $request) {

        $static_page_details = StaticPage::find($request->static_page_id);

        if(!$static_page_details) {
           
            return redirect()->route('admin.static_pages.index')->with('flash_error',tr('static_page_not_found'));

        }

        return view('admin.static_pages.view')
                    ->with('page', 'static_pages')
                    ->with('sub_page','static_pages_view')
                    ->with('static_page_details' , $static_page_details);
    }

    /**
     * @method static_pages_status_change()
     *
     * @uses To update static_page status as DECLINED/APPROVED based on static_page id
     *
     * @created vithya
     *
     * @updated vithya
     *
     * @param - integer static_page_id
     *
     * @return view page 
     */

    public function static_pages_status_change(Request $request) {

        try {

            DB::beginTransaction();

            $static_page_details = StaticPage::find($request->static_page_id);

            if(!$static_page_details) {

                throw new Exception(tr('static_page_not_found'), 101);
                
            }

            $static_page_details->status = $static_page_details->status == DECLINED ? APPROVED : DECLINED;

            $static_page_details->save();

            DB::commit();

            $message = $static_page_details->status == DECLINED ? tr('static_page_decline_success') : tr('static_page_approve_success');

            return redirect()->back()->with('flash_success', $message);

        } catch(Exception $e) {

            DB::rollback();

            $error = $e->getMessage();

            return redirect()->back()->with('flash_error', $error);

        }

    }



}

