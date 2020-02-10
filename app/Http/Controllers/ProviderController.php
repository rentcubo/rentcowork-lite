<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Provider;

use App\Space;

use App\Lookups;

use App\Booking;

use App\BookingProviderReview;

use App\StaticPage;

use DB, Auth, Hash, Validator, Exception;

use App\Helpers\Helper;

class ProviderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth:provider');

        $this->middleware(function ($request, $next) {

            $this->provider= Auth()->guard('provider')->user();

            if($this->provider->status == APPROVED) {

                return $next($request);

            } else {

                Auth::logout();

                return redirect()->route('provider.login')->with('error', tr('you_are_blocked_by_admin'));
            }
        });

    }

    /**
     * @method dashboard()
     * 
     * @uses used to display the dashboard
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param NULL
     *
     * @return view of dashboard and response
     *
     */
    public function dashboard()
    { 

        $provider_id = $this->provider->id;

        $total_spaces = Space::where('provider_id',$provider_id)->count();

        $total_bookings = Booking::where('provider_id',$provider_id)->count();

        $bookings = Booking::where('provider_id',$provider_id)->orderBy('id', 'desc')->take(10)->get();

        $spaces = Space::where('provider_id',$provider_id)->orderBy('id')->take(10)->get();

        $total_earnings = Booking::where('provider_id',$provider_id)->where('status',BOOKING_COMPLETED)->sum('total');

        $today_earnings = Booking::where('provider_id',$provider_id)
                                    ->where('status',BOOKING_COMPLETED)
                                    ->where('updated_at','>',today())->sum('total');

        $dashboard_data['spaces_approved'] = Space::where('provider_id',$provider_id)
                                                    ->where('admin_status', ADMIN_SPACE_APPROVED)->count(); 

        $dashboard_data['spaces_not_approved'] =  Space::where('provider_id',$provider_id)
                                                    ->where('admin_status', ADMIN_SPACE_NOT_APPROVED)->count(); 

        $dashboard_data['spaces_published'] = Space::where('provider_id',$provider_id)
                                                    ->where('status', SPACE_OWNER_PUBLISHED)->count(); 

        $dashboard_data['spaces_not_published'] =  Space::where('provider_id',$provider_id)
                                                    ->where('status',SPACE_OWNER_NOT_PUBLISHED)->count(); 

        $data = json_decode(json_encode($dashboard_data));

        return view('provider.dashboard')
                ->with('total_spaces', $total_spaces)
                ->with('total_bookings', $total_bookings)
                ->with('total_earnings',$total_earnings)
                ->with('today_earnings',$today_earnings)
                ->with('bookings', $bookings)
                ->with('spaces', $spaces)
                ->with('data',$data)
                ->with('page','dashboard');

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

            $provider_details = $this->provider;

            if(!$provider_details){

                throw new Exception(tr('no_profile_found'), 1);
                
            }

            $provider_details->created_at = server_to_client_timeformat($provider_details->created_at, $this->provider->timezone);

            $provider_details->updated_at = server_to_client_timeformat($provider_details->updated_at, $this->provider->timezone);
            
            return view('provider.profile.view')
                        ->with('provider_details', $provider_details)
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
            
            $provider_details = $this->provider;

            if(!$provider_details){

                throw new Exception(tr('no_profile_found'), 1);
                
            }

            return view('provider.profile.edit')
                        ->with(['provider_details' => $provider_details])
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
            
            $provider_details = $this->provider;

            if(!$provider_details){

                throw new Exception(tr('no_profile_found'));
                
            }

            $validator = Validator::make( $request->all(), [

                'name' => 'required|min:3|max:255|regex:/^[a-z A-Z]+$/',

                'email' => 'required|email',

                'description' => 'nullable| min:5|max:255',

                'mobile' => 'digits_between:6,13|nullable',

                'picture' => 'image|nullable|max:2999|mimes:jpeg,bmp,png,jpg',

                'full_address' => 'nullable|min:3|max:100',  

            ]);

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }

            //Handle File Upload
            if($request->hasFile('picture')){

                Helper::delete_file($provider_details->picture,PROFILE_PATH_PROVIDER);

                $provider_details->picture = Helper::upload_file($request->file('picture'),PROFILE_PATH_PROVIDER);

            } 

            $provider_details->name = $request->name ?? $provider_details->name; 

            $provider_details->email = $request->email ?? $provider_details->email;

            $provider_details->description = $request->description ?? $provider_details->description;

            $provider_details->mobile = $request->mobile ?? $provider_details->mobile;

            $provider_details->full_address = $request->full_address ?? $provider_details->full_address;       

            if($provider_details->save()) {

                DB::commit();

                return redirect()->route('provider.profile.view')->with('success', tr('profile_saved'));
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
            
            $provider_details = $this->provider;

            if(!$provider_details){

                throw new Exception(tr('no_profile_found'), 1);                
                
            }

            return view('provider.profile.password')
                    ->with(['provider_details' => $provider_details])
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
            
            $provider_details = $this->provider;

            if(!$provider_details){

                return redirect()->route('provider.profile.view')->with('error',tr('no_profile_found'));
                
            }
              
            $validator = Validator::make( $request->all(),[

                'old_password' => 'required|min:6',

                'password' => 'required|confirmed|min:6',

            ]);

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }

            if (!\Hash::check($request->old_password, $provider_details->password)) {

                throw new Exception(tr('old_password_wrong'), 1);
                 
            }

            $provider_details->password = \Hash::make($request->password);      

            if($provider_details->save()) {

                DB::commit();

                return redirect()->route('provider.profile.view')->with('success', tr('password_changed'));
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

        return view('provider.profile.delete')
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
        
            $provider_details = $this->provider;
       
            if (\Hash::check($request->password, $provider_details->password)) {

                $provider_details->delete();

                DB::commit();

                return redirect()->route('provider.login')->with('success', tr('account_deleted'));
        
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

        $provider_id = $this->provider->id;

        $spaces = Space::where('provider_id',$provider_id)->orderBy('created_at', 'desc')->paginate(10);

        return view('provider.spaces.index')
                    ->with('spaces', $spaces)
                    ->with('page', 'spaces');

    }

    /**
     * @method spaces_create()
     * 
     * @uses used to create the profile of Space
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param NULL
     *
     * @return view of Create Host Page
     *
     */

    public function spaces_create() {

        $space_details = new Space;

        $space_types = [OWN_SPACE , PRIVATE_SPACE, SHARED_SPACE , OFFICE_SPACE];

        return view('provider.spaces.create')->with('space_details', $space_details)
                    ->with('space_types',$space_types)
                    ->with('page','spaces');

    }

    /**
     * @method spaces_save()
     * 
     * @uses used to save the data of space
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param Request of all data
     *
     * @return view of spaces index
     *
     */
    public function spaces_save(Request $request) {

        try{

            DB::beginTransaction();

            $provider = $this->provider;

            if(!$provider) {

                throw new Exception(tr('no_profile_found'), 1);
                
            }

            $provider_id = $this->provider->id;

            $validator = Validator::make( $request->all(),[

                'name' => 'required|min:3|max:255|regex:/^[a-z A-Z]+$/',

                'tagline' => 'required|min:2|max:225',

                'space_type' => 'required|min:6|max:15',

                'description' => 'required| min:5|max:255',

                'per_hour' => 'required|min:1|max:5000|numeric',

                'picture' => 'image|nullable|max:2999|mimes:jpeg,bmp,png,jpg',

                'full_address' => 'required|min:3|max:255',            

                'instructions' => 'nullable|min:3|max:255',

            ]);

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }

            if(!$request->space_details_id){

                //Create Host

                $space_details = New Space;

                $space_details->admin_status = DECLINED;

                $space_details->uploaded_by = PROVIDER;

                $space_details->is_admin_verified = ADMIN_SPACE_NOT_VERIFIED;

                 //Handle File Upload

                $space_details->picture = asset('space-placeholder.jpg  ');

            } else {

                $space_details = Space::find($request->space_details_id);

                 //Handle File Upload
                if($request->hasFile('picture')){

                    Helper::delete_file($space_details->picture, FILE_PATH_SPACE);

                }
                
            }

            $space_details->provider_id = $provider_id;        

            $space_details->name = $request->name;        

            $space_details->space_type = $request->space_type;

            $space_details->description = $request->description;

            $space_details->tagline = $request->tagline;      

            $space_details->full_address = $request->full_address;

            $space_details->per_hour = $request->per_hour; 

            $space_details->instructions = $request->instructions;

            if($request->hasFile('picture')){

                $space_details->picture = Helper::upload_file($request->file('picture'), FILE_PATH_SPACE);

            } 

            if($space_details->save()) {

                DB::commit();

                return redirect()->route('provider.spaces.view', ['space_details_id' => $space_details->id])->with('success', tr('space_saved'));

            }

        }  catch(Exception $e){

            DB::rollback();

            return redirect()->back()->withInput()->with('error',$e->getMessage());
        }
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

            $provider_details = $this->provider;

            if(!$provider_details){

                throw new Exception(tr('no_profile_found'), 1);
                
            }

            $space_details = Space::where('provider_id', $this->provider->id)
                ->where('id', $request->space_details_id)->first();

            if(!$space_details){

                throw new Exception(tr('no_space_found'), 1);
                
            }
            
            $space_details->created_at = server_to_client_timeformat($space_details->created_at, $this->provider->timezone);

            $space_details->updated_at = server_to_client_timeformat($space_details->updated_at, $this->provider->timezone);

            return view('provider.spaces.view')
                        ->with('space_details', $space_details)
                        ->with('page', 'spaces');

        } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * @method spaces_edit()
     * 
     * @uses used to display the edit page
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param integer id
     *
     * @return view of edit page
     *
     */

    public function spaces_edit(Request $request) {

        try{

            $provider_id = $this->provider->id;
            
            $space_details = Space::where('provider_id', $provider_id)
                ->where('id', $request->space_details_id)->first();

            if(!$space_details){

                throw new Exception(tr('no_space_found'), 1);        
                
            }

            $space_types = [OWN_SPACE , PRIVATE_SPACE, SHARED_SPACE , OFFICE_SPACE];

            return view('provider.spaces.edit')->with('space_details', $space_details)
                        ->with('space_types',$space_types)
                        ->with('page','spaces');
        
        }  catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

     /**
     * @method spaces_delete()
     * 
     * @uses used to delete the host
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param integer id
     *
     * @return view of host's index
     *
     */
    public function spaces_delete(Request $request) {

        try{

            $provider_id = $this->provider->id;

            $space_details = Space::where('provider_id', $provider_id)
                ->where('id', $request->space_details_id)->first();

            if(!$space_details){

                throw new Exception(tr('no_space_found'), 1);
                
            }

            $space_details->delete();

            return redirect()->route('provider.spaces.index')->with('success', tr('space_removed'));

        }  catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * @method spaces_status()
     * 
     * @uses used to status of the space
     *
     * @created NAVEEN S
     *
     * @updated
     *
     * @param integer id
     *
     * @return view of space's index
     *
     */
    public function spaces_status(Request $request) {

        try{

            $space_details = Space::find($request->space_details_id);

            if(!$space_details) {
                
                throw new Exception(tr('no_space_found'), 1);
                
            }

            $space_details->status = $space_details->status == SPACE_OWNER_PUBLISHED ? SPACE_OWNER_NOT_PUBLISHED : SPACE_OWNER_PUBLISHED;

            $messege = $space_details->status == SPACE_OWNER_PUBLISHED ? tr('space_published') : tr('space_unpublished');

            $space_details->save();

            return redirect()->back()->with('success', $messege);

        }  catch(Exception $e){

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

        $provider_id = $this->provider->id;

        $bookings = Booking::where('provider_id', $provider_id)->orderBy('created_at', 'desc')->paginate(10);

        foreach ($bookings as $key => $booking_details) {
            
            $booking_details->user_name = $booking_details->users->name ?? tr('not_available');

            $booking_details->space_name = $booking_details->spaces->name ?? tr('not_available');

            $booking_details->space_id = $booking_details->spaces->id ?? tr('not_available');

            $booking_details->checkin = server_to_client_timeformat($booking_details->checkin, $this->provider->timezone);

            $booking_details->checkout = server_to_client_timeformat($booking_details->checkout, $this->provider->timezone);

        }

        return view('provider.bookings.index')
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

            $provider_id = $this->provider->id;

            $booking_details = Booking::where('provider_id', $provider_id)
                ->where('id',$request->booking_details_id)->first();

            if(!$booking_details){

                throw new Exception(tr('no_booking_found'), 1);     
                
            }

            $booking_details->picture = $booking_details->spaces->picture ?? asset('space-placeholder.jpg');

            $booking_details->space_name = $booking_details->spaces->name ?? tr('not_available');

            $booking_details->user_name = $booking_details->users->name ?? tr('not_available');

            $booking_details->providers_review = $booking_details->bookingProviderReviews->review ?? tr('not_available');
            
            $booking_details->rating = $booking_details->bookingProviderReviews->ratings ?? 0;

            $booking_details->checkin = server_to_client_timeformat($booking_details->checkin, $this->provider->timezone);

            $booking_details->checkout = server_to_client_timeformat($booking_details->checkout, $this->provider->timezone);

            $booking_details->created_at = server_to_client_timeformat($booking_details->created_at, $this->provider->timezone);

            $booking_details->updated_at = server_to_client_timeformat($booking_details->updated_at, $this->provider->timezone);

            $booking_details->total_amount = $booking_details->bookingPayments->total;

            $booking_details->paid_amount = $booking_details->bookingPayments->paid_amount;

            $booking_details->paid_date = $booking_details->bookingPayments->paid_date;

            return view('provider.bookings.view')
                    ->with('booking_details', $booking_details)
                    ->with('page','bookings');

        } catch(Exception $e){

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

            $provider_id = $this->provider->id;

            $booking_details = Booking::where('provider_id', $provider_id)
                ->where('id',$request->booking_details_id)->first();

            if(!$booking_details){

                throw new Exception(tr('no_booking_found'), 1);     
                
            }

            $booking_details->status = BOOKING_CANCELLED_BY_PROVIDER;

            $booking_details->bookingPayments->update(['status' => PAYMENT_CANCELLED]);

            $booking_details->save();

            return redirect()->back()->with('success',tr('booking_cancelled'));

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

            $booking_details = Booking::where('provider_id', $this->provider->id)
                                        ->where('id',$request->booking_details_id)->first();

            if(!$booking_details){

                throw new Exception(tr('no_booking_found'), 1);

            }

            if($booking_details->bookingProviderReviews) {

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

            $provider_review = new BookingProviderReview;

            $provider_review->space_id = $booking_details->spaces->id;

            $provider_review->user_id = $booking_details->users->id;

            $provider_review->booking_id = $request->booking_details_id;

            $provider_review->provider_id = $this->provider->id;

            $provider_review->review = $request->review;

            $provider_review->ratings = $request->rating;

            $booking_details->status = BOOKING_COMPLETED;

            $booking_details->save();

            $provider_review->save();

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

        return view('pages.provider_page')->with('page', $page);
    }
}
