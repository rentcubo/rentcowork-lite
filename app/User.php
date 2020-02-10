<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Setting, DB;

use App\Helpers\Helper;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password','login_by', 'timezone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     public static function boot() {

        parent::boot();

        static::creating(function ($model) {

            $model->attributes['is_verified'] = USER_EMAIL_VERIFIED;

            if (Setting::get('is_account_email_verification') == YES && envfile('MAIL_USERNAME') && envfile('MAIL_PASSWORD')) { 

                if($model->attributes['login_by'] == 'manual') {

                    $model->generateEmailCode();

                }

            }

            $model->attributes['status'] = USER_DECLINED;

            $model->attributes['payment_mode'] = COD;

            $model->attributes['name'] = $model->attributes['first_name'].' '.$model->attributes['last_name'] ;

            $model->attributes['username'] = routefreestring($model->attributes['name']);

            $model->attributes['unique_id'] = uniqid();

            $model->attributes['token'] = Helper::generate_token();

            $model->attributes['token_expiry'] = Helper::generate_token_expiry();

            if(in_array($model->attributes['login_by'], ['facebook' , 'google'])) {
                
                $model->attributes['password'] = \Hash::make($model->attributes['social_unique_id']);
            }

        });

        static::created(function($model) {

            $model->attributes['email_notification_status'] = $model->attributes['push_notification_status'] = YES;

            $model->attributes['unique_id'] = "UID"."-".$model->attributes['id']."-".uniqid();

            $model->attributes['token'] = Helper::generate_token();

            $model->attributes['token_expiry'] = Helper::generate_token_expiry();

            $model->save();

            /**
             * @todo Update total number of users 
             */
        
        });

        static::updating(function($model) {

            $model->attributes['name'] = $model->attributes['first_name'].' '.$model->attributes['last_name'] ;

            $model->attributes['username'] = routefreestring($model->attributes['name']);

        });

        static::deleting(function ($model){

            Helper::delete_file($model->picture , PROFILE_PATH_USER);

            $model->bookings()->delete();

            $model->usersreview()->delete();

            $model->providersreview()->delete();

            $model->booking_payment_user()->delete();

        });
    }

    /**
     * Generates Token and Token Expiry
     * 
     * @return bool returns true if successful. false on failure.
     */

    protected function generateEmailCode() {

        $this->attributes['verification_code'] = Helper::generate_email_code();

        $this->attributes['verification_code_expiry'] = Helper::generate_email_expiry();

        // Check Email verification controls and email configurations

        if(Setting::get('is_account_email_verification') == YES && Setting::get('is_email_notification') == YES && Setting::get('is_email_configured') == YES) {

            $this->attributes['is_verified'] = 0;

        } else { 

            $this->attributes['is_verified'] = 1;

        }

        return true;
    
    }

    public function bookings() {

        return $this->hasMany('App\Booking');
    }

    public function usersreview() {

        return $this->hasMany('App\BookingUserReview');
    }

    public function providersreview(){

        return $this->hasMany('App\BookingProviderReview');
    }

    public function providers() {

        return $this->hasMany('App\Provider');
    }

    public function booking_payment_user() {

        return $this->hasMany('App\BookingPayment');
    }

}
