<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB, Auth, Hash, Validator, Exception;

use App\User;

use App\Space;

use App\Lookups;

use App\Booking;

use App\BookingUserReview;

use App\Helpers\Helper;

use App\BookingPayment;

use App\StaticPage;

use Carbon\Carbon;

class UserController extends Controller
{

     Protected $user;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */

    public function __construct() {

        $this->middleware('auth');

        $this->middleware(function ($request, $next) {

            $this->user= Auth::user();

            if($this->user->status == APPROVED) {

                return $next($request);

            } else {

                Auth::logout();

                return redirect('/login')->with('error', tr('you_are_blocked_by_admin'));
            }
        });

    }

    /**
     * @method profile_view()
     * 
     * @uses used to display the view page
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param 
     *
     * @return view of particular profile
     *
     */
    public function profile_view() {

        try{

            $user_details = $this->user;

            if(!$user_details){

                throw new Exception(tr('no_profile_found'), 1);
                
            }
            
            $user_details->created_at = server_to_client_timeformat($user_details->created_at, $this->user->timezone);

            $user_details->updated_at = server_to_client_timeformat($user_details->updated_at, $this->user->timezone);

            return view('user.profile.view')
                        ->with('user_details', $user_details)
                        ->with('page','profile');

        } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * @method profile_edit()
     * 
     * @uses used to edit the profile
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param integer id
     *
     * @return profile edit form
     *
     */

    public function profile_edit() {

        try{
            
            $user_details = $this->user;

            if(!$user_details){

                throw new Exception(tr('no_profile_found'), 1);
                
            }

            return view('user.profile.edit')
                        ->with(['user_details' => $user_details])
                        ->with('page','profile');

         } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * @method profile_update() 
     * 
     * @uses used to save the data of profile
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param Request of all data
     *
     * @return view of profile view
     *
     */
    public function profile_update(Request $request) {
    
        try{

            DB::beginTransaction();
            
            $user_details = $this->user;

            if(!$user_details){

                throw new Exception(tr('no_profile_found'));
                
            }

            $validator = Validator::make( $request->all(), [

                'first_name' => 'required|min:3|max:125|regex:/^[a-z A-Z]+$/',

                'last_name' => 'required|min:1|max:125|regex:/^[a-z A-Z]+$/',

                'email' => 'required|email',

                'description' => 'nullable| min:5|max:255',

                'mobile' => 'digits_between:6,13|nullable',

                'picture' => 'image|nullable|max:2999|mimes:jpeg,bmp,png,jpg',

            ]);

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }

            //Handle File Upload
            if($request->hasFile('picture')){

                Helper::delete_file($user_details->picture,PROFILE_PATH_USER);

                $user_details->picture = Helper::upload_file($request->file('picture'),PROFILE_PATH_USER);

            } 

            $user_details->first_name = $request->first_name ?? $user_details->first_name; 

            $user_details->last_name = $request->last_name ?? $user_details->last_name; 

            $user_details->email = $request->email ?? $user_details->email;

            $user_details->description = $request->description ?? $user_details->description;

            $user_details->mobile = $request->mobile ?? $user_details->mobile;     

            if($user_details->save()) {

                DB::commit();

                return redirect()->route('profile.view')->with('success', tr('profile_saved'));
            }

        } catch(Exception $e){

            DB::rollback();

            return redirect()->back()->withInput()->with('error',$e->getMessage());
        }
    }

    /**
     * @method change_password()
     * 
     * @uses used to view password page
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param Request of all data
     *
     * @return view of profile password view
     *
     */
    public function change_password(Request $request) {
        
        try {
            
            $user_details = $this->user;

            if(!$user_details){

                throw new Exception(tr('no_profile_found'), 1);                
                
            }

            return view('user.profile.password')
                    ->with(['user_details' => $user_details])
                    ->with('page', 'profile');

        } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }

    }


    /**
     * @method update_password()
     * 
     * @uses used to save the password
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param Request of all data
     *
     * @return view of profile view
     *
     */
    public function update_password(Request $request) {
        
        try{ 

            DB::beginTransaction();
            
            $user_details = $this->user;

            if(!$user_details){

                return redirect()->route('profile.view')->with('error',tr('no_profile_found'));
                
            }
              
            $validator = Validator::make( $request->all(),[

                'old_password' => 'required|min:6',

                'password' => 'required|confirmed|min:6',

            ]);

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }

            if (!\Hash::check($request->old_password, $user_details->password)) {

                throw new Exception(tr('old_password_wrong'), 1);
                 
            }

            $user_details->password = \Hash::make($request->password);      

            if($user_details->save()) {

                DB::commit();

                return redirect()->route('profile.view')->with('success', tr('password_changed'));
            }

        } catch(Exception $e){

            DB::rollback();

            return redirect()->back()->with('error',$e->getMessage());
        }
        
    }

    /**
     * @method password_check()
     * 
     * @uses checking password before deleting the provider
     *
     * @created Naveen
     *
     * @updated 
     *
     * @param integer id
     *
     * @return view of profile's view
     *
     */
    public function password_check() {

        return view('user.profile.delete')
                    ->with('page','profile');
    }

    /**
     * @method  account_delete()
     * 
     * @uses check the password and delete the provider.
     *
     * @created Akshata
     *
     * @updated
     *
     * @param 
     *
     * @return view of profile's view
     *
     */
    public function account_delete(Request $request) {
        try{

            DB::beginTransaction();
        
            $user_details = $this->user;
       
            if (\Hash::check($request->password, $user_details->password)) {

                $user_details->delete();

                DB::commit();

                return redirect()->route('login')->with('success', tr('account_deleted'));
        
            }

            throw new Exception(tr('password_not_match'));

        } catch(Exception $e){

            DB::rollback();

            return redirect()->back()->with('error',$e->getMessage());
        }
        
    }


     /**
     * @method spaces_index()
     * 
     * @uses used to display the list of spaces
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param NULL
     *
     * @return view of spaces list
     *
     */
    public function spaces_index() {

        $spaces = Space::where('admin_status',ADMIN_SPACE_APPROVED)->where('status',SPACE_OWNER_PUBLISHED)->orderBy('created_at', 'desc')->paginate(20);

        return view('user.spaces.index')
                    ->with('spaces', $spaces)
                    ->with('page', 'spaces');

    }

    /**
     * @method spaces_view()
     * 
     * @uses used to display the view page
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param id
     *
     * @return view of particular space
     *
     */
    public function spaces_view(Request $request) {

        try{

            $space_details = Space::where('admin_status',ADMIN_SPACE_APPROVED)->where('status',SPACE_OWNER_PUBLISHED)
                ->where('id', $request->space_details_id)->first();

            if(!$space_details){

                throw new Exception(tr('no_space_found'), 1);
                
            }

            $space_details->created_at = server_to_client_timeformat($space_details->created_at, $this->user->timezone);

            $space_details->updated_at = server_to_client_timeformat($space_details->updated_at, $this->user->timezone);
            
            return view('user.spaces.view')
                        ->with('space_details', $space_details)
                        ->with('page', 'spaces');

        } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
    }


     /**
     * @method bookings_index()
     * 
     * @uses used to display the list of booking 
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param NULL
     *
     * @return view of booking list
     *
     */
    public function bookings_index() {

        $user_id = $this->user->id;

        $bookings = Booking::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(10);

        foreach ($bookings as $key => $booking_details) {
            
            $booking_details->user_name = $booking_details->users->name ?? tr('not_available');

            $booking_details->space_name = $booking_details->spaces->name ?? tr('not_available');

            $booking_details->space_id = $booking_details->spaces->id ?? tr('not_available');

            $booking_details->checkin = server_to_client_timeformat($booking_details->checkin, $this->user->timezone);

            $booking_details->checkout = server_to_client_timeformat($booking_details->checkout, $this->user->timezone);

        }

        return view('user.bookings.index')
                    ->with('bookings', $bookings)
                    ->with('page', 'bookings');        
 
    }

    /**
     * @method bookings_view()
     * 
     * @uses used to display the Booking Details Page
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param id
     *
     * @return view of particular Booking
     *
     */
    public function bookings_view(Request $request) {

        try{

            $user_id = $this->user->id;

            $booking_details = Booking::where('user_id', $user_id)
                ->where('id',$request->booking_details_id)->first();

            if(!$booking_details){

                throw new Exception(tr('no_booking_found'), 1);     
                
            }

            $booking_details->picture = $booking_details->spaces->picture ?? asset('space-placeholder.jpg');

            $booking_details->space_name = $booking_details->spaces->name ?? tr('not_available');

            $booking_details->user_name = $booking_details->users->name ?? tr('not_available');

            $booking_details->users_review = $booking_details->bookingUserReviews->review ?? tr('not_available');

            $booking_details->rating = $booking_details->bookingUserReviews->ratings ?? tr('not_available');

            $booking_details->checkin = server_to_client_timeformat($booking_details->checkin, $this->user->timezone);

            $booking_details->checkout = server_to_client_timeformat($booking_details->checkout, $this->user->timezone);

            $booking_details->created_at = server_to_client_timeformat($booking_details->created_at, $this->user->timezone);

            $booking_details->updated_at = server_to_client_timeformat($booking_details->updated_at, $this->user->timezone);

            $booking_details->total_amount = $booking_details->bookingPayments->total;

            $booking_details->paid_amount = $booking_details->bookingPayments->paid_amount;

            $booking_details->paid_date = $booking_details->bookingPayments->paid_date;

            return view('user.bookings.view')
                    ->with('booking_details', $booking_details)
                    ->with('page','bookings');

        } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

     /**
     * @method bookings_save()
     * 
     * @uses used to save the booking of user
     *
     * @created NAVEEN S
     *
     * @updated 
     *
     * @param Request of all data
     *
     * @return booking list page
     *
     */
    public function bookings_save(Request $request) {

        try {

            DB::beginTransaction();

            $space_details = Space::where('id', $request->space_details_id)->first();

            if(!$space_details) {

                throw new Exception(tr('no_space_found'), 1);

            }

            $current_time = server_to_client_timeformat(now(),$request->timezone);

            $validator = Validator::make( $request->all(), [

                'check_in' => 'required|date_format:"d/m/Y H:i:s"|after:'.$current_time,

                'check_out' => 'required|date_format:"d/m/Y H:i:s"|after:check_in',

                'description' => 'required|min:3|max:255'

            ]); 

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }
            
            $check_in = Carbon::createFromFormat('d/m/Y H:i:s', $request->check_in);

            $check_out = Carbon::createFromFormat('d/m/Y H:i:s', $request->check_out);

            $duration_min = $check_in->diffInMinutes($check_out);

            $duration = $duration_min/60;
            
            $per_hour = $space_details->per_hour;

            $total = $duration * $per_hour;

            $booking_details = new Booking;

            $booking_details->user_id = $this->user->id;

            $booking_details->provider_id = $space_details->provider_id;

            $booking_details->space_id = $space_details->id;

            $booking_details->description = $request->description;

            $booking_details->checkin = client_to_server_timeformat($check_in, $this->user->timezone);

            $booking_details->checkout = client_to_server_timeformat($check_out, $this->user->timezone);

            $booking_details->payment_mode = COD;

            $booking_details->currency = setting()->get('currency');

            $booking_details->total_time = $duration;

            $booking_details->per_hour = $per_hour;

            $booking_details->total = $total;

            $booking_details->status = BOOKING_INITIATE;

            $booking_details->save();

            $booking_payment_details = New BookingPayment;

            $booking_payment_details->booking_id = $booking_details->id;

            $booking_payment_details->user_id = $this->user->id;

            $booking_payment_details->provider_id = $booking_details->provider_id;

            $booking_payment_details->space_id = $booking_details->space_id;

            $booking_payment_details->payment_mode = $booking_details->payment_mode;

            $booking_payment_details->currency = $booking_details->currency;

            $booking_payment_details->total_time = $booking_details->total_time;

            $booking_payment_details->per_hour = $booking_details->per_hour;

            $booking_payment_details->sub_total = $booking_details->total;

            $booking_payment_details->tax_price = (setting()->get('tax_percentage')/100) * $booking_payment_details->sub_total;

            $booking_payment_details->total = $booking_payment_details->sub_total + $booking_payment_details->tax_price;

            $booking_payment_details->admin_amount = $booking_payment_details->total * ( setting()->get('admin_commission')/100);

            $booking_payment_details->provider_amount = $booking_payment_details->total - $booking_payment_details->admin_amount;

            $booking_payment_details->status = PAYMENT_NOT_PAID;

            $booking_payment_details->save();

            DB::commit();

            return redirect()->route('bookings.index')->with('success', tr('booking_created'));  

        } catch(Exception $e){

            DB::rollback();

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * @method bookings_cancel()
     * 
     * @uses used to status of the booking
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param integer id
     *
     * @return view of booking's index
     *
     */
    public function bookings_cancel(Request $request) {

        try{

            $booking_details = Booking::where('user_id', $this->user->id)
                ->where('id',$request->booking_details_id)->first();

            if(!$booking_details){

                throw new Exception(tr('no_booking_found'), 1);     
                
            }

            $booking_details->status = BOOKING_CANCELLED_BY_USER;

            $booking_details->bookingPayments->update(['status' => PAYMENT_CANCELLED]);

            $booking_details->save();

            return redirect()->back()->with('success',tr('booking_cancelled'));

        } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * @method bookings_payment()
     * 
     * @uses To checkin the space
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param integer id
     *
     * @return checkin status
     *
     */
    public function bookings_payment(Request $request) {

        try {

            $booking_details = Booking::where('user_id', $this->user->id)
                                ->where('id',$request->booking_details_id)->first();

            if(!$booking_details){

                throw new Exception(tr('no_booking_found'), 1);
                
            }

            if($booking_details->status == BOOKING_CANCELLED_BY_PROVIDER) {

                throw new Exception(tr('booking_cancelled_by_provider'), 1);
                
            }
            
            $booking_details->status = BOOKING_PAYMENT_DONE;

            $booking_details->bookingPayments->update([
                
                'paid_amount' => $booking_details->bookingPayments->total,

                'paid_date' => now(),

                'status' => PAYMENT_PAID
            ]);

            $booking_details->save();

            return redirect()->back()->with('success', tr('payment_completed'));

        } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
               
    }

    /**
     * @method bookings_checkin()
     * 
     * @uses To checkin the space
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param integer id
     *
     * @return checkin status
     *
     */
    public function bookings_checkin(Request $request) {

        try {

            $booking_details = Booking::where('user_id', $this->user->id)
                                ->where('id',$request->booking_details_id)->first();

            if(!$booking_details){

                throw new Exception(tr('no_booking_found'), 1);
                
            }

            if($booking_details->status == BOOKING_CANCELLED_BY_PROVIDER) {

                throw new Exception(tr('booking_cancelled_by_provider'), 1);
                
            }

            $booking_details->status = BOOKING_CHECKIN;

            $booking_details->checkin = now();

            $booking_details->save();

            return redirect()->back()->with('success', tr('checkin_completed'));

        } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
               
    }

    /**
     * @method bookings_checkout()
     * 
     * @uses To checkout from space
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param integer id
     *
     * @return checkout status
     *
     */
    public function bookings_checkout(Request $request) {

        try{

            $booking_details = Booking::where('user_id', $this->user->id)
                                ->where('id',$request->booking_details_id)->first();

            if(!$booking_details){

                throw new Exception(tr('no_booking_found'), 1);
                
            }

            $booking_details->status = BOOKING_CHECKOUT;

            $booking_details->checkout = now();

            $booking_details->save();

            return redirect()->back()->with('success', tr('checkout_completed'));

        } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * @method bookings_review()
     * 
     * @uses used to review of the booking
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param integer id
     *
     * @return view of booking's index
     *
     */
    public function bookings_review(Request $request) {

        try {

            DB::beginTransaction();

            $booking_details = Booking::where('user_id', $this->user->id)
                                        ->where('id',$request->booking_details_id)->first();

            if(!$booking_details){

                throw new Exception(tr('no_booking_found'), 1);

            }

            if($booking_details->bookingUserReviews) {

                throw new Exception(tr('already_review_updated'), 1);
                
            }

            $validator = Validator::make( $request->all(), [

                'booking_id' => 'required',

                'review' => 'required|min:3',

                'rating' => 'required|numeric|min:1|max:5',

            ]);

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }

            $user_review = new BookingUserReview;

            $user_review->space_id = $booking_details->spaces->id;

            $user_review->provider_id = $booking_details->providers->id;

            $user_review->booking_id = $request->booking_details_id;

            $user_review->user_id = $this->user->id;

            $user_review->review = $request->review;

            $user_review->ratings = $request->rating;

            $booking_details->status = BOOKING_REVIEW_DONE;

            $booking_details->save();

            $user_review->save();

            DB::commit();

            return redirect()->back()->with('success',tr('review_updated'));

        } catch(Exception $e){

            DB::rollback();

            return redirect()->back()->with('error',$e->getMessage());

        }
    }

    /**
     * @method pages()
     * 
     * @uses To display the view page
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param Request of Page type
     *
     * @return view of page
     *
     */
    public function pages(Request $request) {
        
        $page = StaticPage::where('type',$request->page_type)->where('status',APPROVED)->first();

        return view('pages.user_page')->with('page', $page);
    }
}
