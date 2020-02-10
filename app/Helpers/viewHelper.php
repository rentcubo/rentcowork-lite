<?php

use App\Helpers\Helper;

use Carbon\Carbon;

use App\User, App\Provider;

use App\MobileRegister, App\PageCounter, App\Settings;

use App\Host;

use App\BookingPayment, App\BookingUserReview, App\BookingProviderReview;

/**
 * @method tr()
 *
 * @uses used to convert the string to language based string
 *
 * @created Vidhya R
 *
 * @updated
 *
 * @param string $key
 *
 * @return string value
 */
function tr($key , $other_key = "" , $lang_path = "messages.") {

    // if(Auth::guard('admin')->check()) {

    //     $locale = config('app.locale');

    // } else {

        if (!\Session::has('locale')) {

            $locale = \Session::put('locale', config('app.locale'));

        }else {

            $locale = \Session::get('locale');

        }
    // }
    return \Lang::choice('messages.'.$key, 0, Array('other_key' => $other_key), $locale);
}
/**
 * @method envfile()
 *
 * @uses get the configuration value from .env file 
 *
 * @created Vidhya R
 *
 * @updated
 *
 * @param string $key
 *
 * @return string value
 */

function envfile($key) {

    $data = getEnvValues();

    if($data) {
        return $data[$key];
    }

    return "";

}


function getEnvValues() {

    $data =  [];

    $path = base_path('.env');

    if(file_exists($path)) {

        $values = file_get_contents($path);

        $values = explode("\n", $values);

        foreach ($values as $key => $value) {

            $var = explode('=',$value);

            if(count($var) == 2 ) {
                if($var[0] != "")
                    $data[$var[0]] = $var[1] ? $var[1] : null;
            } else if(count($var) > 2 ) {
                $keyvalue = "";
                foreach ($var as $i => $imp) {
                    if ($i != 0) {
                        $keyvalue = ($keyvalue) ? $keyvalue.'='.$imp : $imp;
                    }
                }
                $data[$var[0]] = $var[1] ? $keyvalue : null;
            }else {
                if($var[0] != "")
                    $data[$var[0]] = null;
            }
        }

        array_filter($data);
    
    }

    return $data;

}

/**
 * @method register_mobile()
 *
 * @uses Update the user register device details 
 *
 * @created Vidhya R
 *
 * @updated
 *
 * @param string $device_type
 *
 * @return - 
 */

function register_mobile($device_type) {

    if($reg = MobileRegister::where('type' , $device_type)->first()) {

        $reg->count = $reg->count + 1;

        $reg->save();
    }
    
}

/**
 * @uses subtract_count()
 *
 * @uses While Delete user, subtract the count from mobile register table based on the device type
 *
 * @created vithya R
 *
 * @updated vithya R
 *
 * @param string $device_ype : Device Type (Andriod,web or IOS)
 * 
 * @return boolean
 */

function subtract_count($device_type) {

    if($reg = MobileRegister::where('type' , $device_type)->first()) {

        $reg->count = $reg->count - 1;
        
        $reg->save();
    }

}

/**
 * @method get_register_count()
 *
 * @uses Get no of register counts based on the devices (web, android and iOS)
 *
 * @created Vidhya R
 *
 * @updated
 *
 * @param - 
 *
 * @return array value
 */

function get_register_count() {

    $ios_count = MobileRegister::where('type' , 'ios')->get()->count();

    $android_count = MobileRegister::where('type' , 'android')->get()->count();

    $web_count = MobileRegister::where('type' , 'web')->get()->count();

    $total = $ios_count + $android_count + $web_count;

    return array('total' => $total , 'ios' => $ios_count , 'android' => $android_count , 'web' => $web_count);

}


/**
 * @uses this function convert string to UTC time zone
 */

function convertTimeToUTCzone($date, $user_timezone, $format = 'Y-m-d H:i:s') {

    $formatted_date = new DateTime($date, new DateTimeZone($user_timezone));

    $formatted_date->setTimeZone(new DateTimeZone('UTC'));

    return $formatted_date->format( $format);
}

/**
 * @uses this function converts string from UTC time zone to current user timezone
 */

function convertTimeToUSERzone($str, $userTimezone, $format = 'Y-m-d H:i:s') {

    if(empty($str)) {

        return '';
    }
    
    try {
        
        $new_str = new DateTime($str, new DateTimeZone('UTC') );
        
        $new_str->setTimeZone(new DateTimeZone( $userTimezone ));
    }
    catch(\Exception $e) {
        // Do Nothing

        return '';
    }
    
    return $new_str->format( $format);

}


function common_date($date , $timezone = "" , $format = "d M Y h:i A") {

    if($date == "0000-00-00 00:00:00" || $date == "0000-00-00" || !$date) {

        return $date = '';
    }

    if($timezone) {

        $date = convertTimeToUSERzone($date, $timezone, $format);

    }

    return $timezone ? $date : date($format, strtotime($date));

}


/**
 * @method formatted_amount()
 *
 * @uses used to format the number
 *
 * @created vidhya R
 *
 * @updated vidhya R
 *
 * @param integer $num
 * 
 * @param string $currency
 *
 * @return string $formatted_amount
 */

function formatted_amount($amount = 0.00, $currency = "") {

    $currency = $currency ?: Setting::get('currency', '$');

    $amount = number_format((float)$amount, 2, '.', '');

    $formatted_amount = $currency."".$amount ?: "0.00";

    return $formatted_amount;
}

/**
 * @method routefreestring()
 * 
 * @uses used for remove the route parameters from the string
 *
 * @created vidhya R
 *
 * @updated vidhya R
 *
 * @param string $string
 *
 * @return Route parameters free string
 */

function routefreestring($string) {

    $string = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $string));
    
    $search = [' ', '&', '%', "?",'=','{','}','$'];

    $replace = ['-', '-', '-' , '-', '-', '-' , '-','-'];

    $string = str_replace($search, $replace, $string);

    return $string;
    
}


function booking_status($status) {

    switch($status){

        case(BOOKING_INITIATE):
          return tr('booking_initiated');
        break;

        case(BOOKING_ONPROGRESS);
          return tr('booking_onprogress');
        break;

        case(BOOKING_WAITING_FOR_PAYMENT):
          return tr('booking_waiting_for_payment');
        break;

        case(BOOKING_PAYMENT_DONE);
          return tr('booking_payment_done');
        break;

        case(BOOKING_CANCELLED_BY_USER):
          return tr('booking_cancelled_by_user');
        break;

        case(BOOKING_CANCELLED_BY_PROVIDER);
          return tr('booking_cancelled_by_provider');
        break;

        case(BOOKING_COMPLETED):
          return tr('booking_completed');
        break;

        case(BOOKING_REFUND_INITIATED);
          return tr('booking_refund_initiated');
        break;

        case(BOOKING_CHECKIN):
           return tr('booking_checkin') ;
        break;

        case(BOOKING_CHECKOUT):
          return  tr('booking_checkout');
        break;

        case(BOOKING_REVIEW_DONE):
          return  tr('booking_review_done') ;
        break;

        case(BOOKING_APPROVED_BY_PROVIDER):
          return  tr('booking_approved_by_provider') ;
        break;

        case(BOOKING_REJECTED_BY_PROVIDER):
          return  tr('booking_rejected_by_provider') ;
        break;

    }
}

function booking_status_color($status) {

    switch($status){

        case(BOOKING_INITIATE):
          return "badge-primary";
        break;

        case(BOOKING_ONPROGRESS);
          return "badge-info";
        break;

        case(BOOKING_WAITING_FOR_PAYMENT):
          return "badge-primary";
        break;

        case(BOOKING_PAYMENT_DONE);
          return "badge-info";
        break;

        case(BOOKING_CANCELLED_BY_USER):
          return "badge-danger";
        break;

        case(BOOKING_CANCELLED_BY_PROVIDER);
          return "badge-danger";
        break;

        case(BOOKING_COMPLETED):
          return "badge-success";
        break;

        case(BOOKING_REFUND_INITIATED);
          return "badge-info";
        break;

        case(BOOKING_CHECKIN):
           return "badge-primary";
        break;

        case(BOOKING_CHECKOUT):
          return "badge-info";
        break;

        case(BOOKING_REVIEW_DONE):
          return "badge-success";
        break;

        case(BOOKING_APPROVED_BY_PROVIDER):
          return "badge-success";
        break;

        case(BOOKING_REJECTED_BY_PROVIDER):
          return "badge-danger";
        break;

    }
}

/**
 * @method time_show()
 *
 * @uses To show the hour
 *
 * @created Naveen
 *
 * @updated 
 *
 * @param integer hour
 *
 * @return string hour
 */

function time_show($hour = 0.00) {

    $total_days = floor($hour/24);

    $total_months = floor($total_days/30);

    $total_hours =  $hour%24;

    $total_minutes = ($hour*60) % 60;

    if($total_months == 1) {

        $total_months = $total_months." month";

    } else if($total_months == 0){

        $total_months = NULL;

    } else {

        $total_months = $total_months." months";

    }

    if($total_days == 1) {

        $total_days = $total_days." day";

    } else if($total_days == 0){

        $total_days = NULL;

    } else {

        $total_days = $total_days." days";
    }


    if($total_hours == 1) {

        $total_hours = $total_hours." hour";

    } else if($total_hours == 0){

        $total_hours = NULL;

    } else {

        $total_hours =  $total_hours." hours";
    }

    if($total_minutes == 1) {

        $total_minutes = $total_minutes." minute";

    } else if($total_minutes == 0){

        $total_minutes = NULL;

    } else {

        $total_minutes =  $total_minutes." minutes";
    }

    return $total_months.' '.$total_days.' '.$total_hours.' '.$total_minutes;
}


/**
 * @method client_to_server_timeformat()
 *
 * @uses To store time in UTC
 *
 * @created Naveen
 *
 * @updated 
 *
 * @param time, timezone, format
 *
 * @return server_time
 */
function client_to_server_timeformat($time, $timezone, $format = 'Y-m-d H:i:s' ) {

    $server_time = Carbon::createFromFormat($format, $time, $timezone);

    $server_time->setTimezone(new DateTimeZone('UTC'));

    return $server_time;
}


/**
 * @method time_show()
 *
 * @uses To show time in current timezone
 *
 * @created Naveen
 *
 * @updated 
 *
 * @param time, timezone, format
 *
 * @return client_time
 */

function server_to_client_timeformat($time, $timezone, $format = 'Y-m-d H:i:s' ) {

    $client_time = Carbon::createFromFormat($format, $time);

    $client_time->setTimezone(new DateTimeZone($timezone));
    
    return $client_time;
}