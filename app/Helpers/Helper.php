<?php 

namespace App\Helpers;

use Hash, Exception, Auth, Mail, File, Log, Storage, Setting, DB;

use App\Admin, App\User, App\Provider;

use App\Category, App\Settings, App\StaticPage;

class Helper {
	

    public static function clean($string) {

        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public static function generate_token() {
        
        return Helper::clean(Hash::make(rand() . time() . rand()));
    }

    public static function generate_token_expiry() {

        $token_expiry_hour = Setting::get('token_expiry_hour') ?: 1;
        
        return time() + $token_expiry_hour*3600;  // 1 Hour
    }

    // Note: $error is passed by reference
    
    public static function is_token_valid($entity, $id, $token, &$error) {

        if (
            ( $entity== USER && ($row = User::where('id', '=', $id)->where('token', '=', $token)->first()) ) ||
            ( $entity== PROVIDER && ($row = Provider::where('id', '=', $id)->where('token', '=', $token)->first()) )
        ) {

            if ($row->token_expiry > time()) {
                // Token is valid
                $error = NULL;
                return true;
            } else {
                $error = ['success' => false, 'error' => Helper::error_message(1003), 'error_code' => 1003];
                return FALSE;
            }
        }

        $error = ['success' => false, 'error' => Helper::error_message(1004), 'error_code' => 1004];
        return FALSE;
   
    }

    public static function generate_email_code($value = "") {

        return uniqid($value);
    }

    public static function generate_email_expiry() {

        $token_expiry = Setting::get('token_expiry_hour') ?: 1;
            
        return time() + $token_expiry*3600;  // 1 Hour

    }

    // Check whether email verification code and expiry

    public static function check_email_verification($verification_code , $user_id , &$error,$common) {

        if(!$user_id) {

            $error = tr('user_id_empty');

            return FALSE;

        } else {

            if($common == USER) {
                $user_details = User::find($user_id);
            } else if($common == PROVIDER) {
                $user_details = Provider::find($user_id);
            }
        }

        // Check the data exists

        if($user_details) {

            // Check whether verification code is empty or not

            if($verification_code) {

                // Log::info("Verification Code".$verification_code);

                // Log::info("Verification Code".$user_details->verification_code);

                if ($verification_code ===  $user_details->verification_code ) {

                    // Token is valid

                    $error = NULL;

                    // Log::info("Verification CODE MATCHED");

                    return true;

                } else {

                    $error = tr('verification_code_mismatched');

                    // Log::info(print_r($error,true));

                    return FALSE;
                }

            }
                
            // Check whether verification code expiry 

            if ($user_details->verification_code_expiry > time()) {

                // Token is valid

                $error = NULL;

                Log::info(tr('token_expiry'));

                return true;

            } else if($user_details->verification_code_expiry < time() || (!$user_details->verification_code || !$user_details->verification_code_expiry) ) {

                $user_details->verification_code = Helper::generate_email_code();
                
                $user_details->verification_code_expiry = Helper::generate_email_expiry();
                
                $user_details->save();

                // If code expired means send mail to that user

                $subject = tr('verification_code_title');
                $email_data = $user_details;
                $page = "emails.welcome";
                $email = $user_details->email;
                $result = Helper::send_email($page,$subject,$email,$email_data);

                $error = tr('verification_code_expired');

                Log::info(print_r($error,true));

                return FALSE;
            }
       
        }

    }
    
    public static function generate_password() {

        $new_password = time();
        $new_password .= rand();
        $new_password = sha1($new_password);
        $new_password = substr($new_password,0,8);
        return $new_password;
    }

    public static function file_name() {

        $file_name = time();
        $file_name .= rand();
        $file_name = sha1($file_name);

        return $file_name;    
    }

    public static function upload_file($picture , $folder_path = COMMON_FILE_PATH) {

        $file_path_url = "";

        $file_name = Helper::file_name();

        $ext = $picture->getClientOriginalExtension();

        $local_url = $file_name . "." . $ext;

        $inputFile = base_path('public'.$folder_path.$local_url);

        $picture->move(public_path().$folder_path, $local_url);

        $file_path_url = Helper::web_url().$folder_path.$local_url;

        return $file_path_url;
    
    }

    public static function web_url() 
    {
        return url('/');
    }
    
    public static function delete_file($picture, $path = COMMON_FILE_PATH) {

        if ( file_exists( public_path() . $path . basename($picture))) {

            File::delete( public_path() . $path . basename($picture));
      
        } else {

            return false;
        }  

        return true;    
    }
 
    public static function send_email($page,$subject,$email,$email_data,$model) {

        // check the email notification

        if(Setting::get('is_email_notification') == YES) {

            // Don't check with envfile function. Because without configuration cache the email will not send

            if( config('mail.username') &&  config('mail.password')) {

                try {

                    $site_url=url('/');

                    $isValid = 1;

                    if(envfile('MAIL_DRIVER') == 'mailgun' && Setting::get('MAILGUN_PUBLIC_KEY')) {

                        Log::info("isValid - STRAT");

                        # Instantiate the client.

                        $email_address = new Mailgun(Setting::get('MAILGUN_PUBLIC_KEY'));

                        $validateAddress = $email;

                        # Issue the call to the client.
                        $result = $email_address->get("address/validate", ['address' => $validateAddress]);

                        # is_valid is 0 or 1

                        $isValid = $result->http_response_body->is_valid;

                        Log::info("isValid FINAL STATUS - ".$isValid);

                    }

                    if($isValid) {

                        /*Mail::queue($page, ['email_data' => $email_data,'site_url' => $site_url], 
                                function ($message) use ($email, $subject) {

                                    $message->to($email)->subject($subject);
                                }
                        )*/
                        $responce = Mail::to($email)->queue($model);
                        Log::info("SUCCESS - ");
                        if (Mail::failures()) {
                            
                            throw new Exception(Helper::error_message(116) , 116);
                            

                        } else {

                            $message = Helper::success_message(102);

                            $response_array = ['success' => true , 'message' => $message];

                            return json_decode(json_encode($response_array));
                            
                        }

                    } else {

                        $error = Helper::error_message();

                        throw new Exception($error, 115);                  

                    }

                } catch(\Exception $e) {

                    $error = $e->getMessage();

                    $error_code = $e->getCode();

                    $response_array = ['success' => false , 'error' => $error , 'error_code' => $error_code];
                    
                    return json_decode(json_encode($response_array));

                }
            
            } else {

                $error = Helper::error_message(106);

                $response_array = ['success' => false , 'error' => $error , 'error_code' => 106];
                    
                return json_decode(json_encode($response_array));

            }
        
        } else {
            
            Log::info("email notification disabled by admin");

            $error = Helper::error_message(227);

            $response_array = ['success' => false , 'error' => $error , 'error_code' => 227];
                
            return json_decode(json_encode($response_array));
        }
    
    }
      
    // Convert all NULL values to empty strings
    public static function null_safe($input_array) {
 
        $new_array = [];

        foreach ($input_array as $key => $value) {

            $new_array[$key] = ($value == NULL) ? "" : $value;
        }

        return $new_array;
    }
    
    /**
     * @method settings_generate_json()
     *
     * @uses used to update settings.json file with updated details.
     *
     * @created vidhya
     * 
     * @updated vidhya
     *
     * @param -
     *
     * @return boolean
     */
    
    public static function settings_generate_json() {

        $basic_keys = ['site_name', 'site_logo', 'site_icon', 'currency', 'currency_code', 'google_analytics', 'header_scripts', 'body_scripts', 'facebook_link', 'linkedin_link', 'twitter_link', 'google_plus_link', 'pinterest_link', 'demo_user_email', 'demo_user_password', 'demo_provider_email', 'demo_provider_password', 'chat_socket_url', 'google_api_key'];

        $settings = Settings::whereIn('key', $basic_keys)->get();

        $sample_data = [];

        foreach ($settings as $key => $setting_details) {

            $sample_data[$setting_details->key] = $setting_details->value;
        }
        // Social logins

        $social_login_keys = ['FB_CLIENT_ID', 'FB_CLIENT_SECRET', 'FB_CALL_BACK' , 'TWITTER_CLIENT_ID', 'TWITTER_CLIENT_SECRET', 'TWITTER_CALL_BACK', 'GOOGLE_CLIENT_ID', 'GOOGLE_CLIENT_SECRET', 'GOOGLE_CALL_BACK'];

        $social_logins = Settings::whereIn('key', $social_login_keys)->get();

        $social_login_data = [];

        foreach ($social_logins as $key => $social_login_details) {

            $social_login_data[$social_login_details->key] = $social_login_details->value;
        }

        $sample_data['social_logins'] = $social_login_data;

        $data['data'] = $sample_data;

        $data = json_encode($data);

        $file_name = public_path('/default-json/settings.json');

        File::put($file_name, $data);
    }
    

}


