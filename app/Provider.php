<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

use Setting,DB;

use App\Helpers\Helper;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\ProviderResetPasswordNotification;

class Provider extends Authenticatable
{      

    use Notifiable;

    public function sendPasswordResetNotification($token) {

        $this->notify(new ProviderResetPasswordNotification($token));
    }
    
    public static function boot() {

        parent::boot();

        static::creating(function ($model) {

            $model->attributes['first_name'] = $model->attributes['last_name'] = $model->attributes['name'];

            $model->attributes['is_verified'] = PROVIDER_EMAIL_VERIFIED;

            if (Setting::get('is_account_email_verification') == YES && envfile('MAIL_USERNAME') && envfile('MAIL_PASSWORD')) { 

                if($model->login_by == 'manual') {

                    $model->generateEmailCode();

                }

            }

            $model->attributes['status'] = PROVIDER_APPROVED;

            $model->attributes['username'] = routefreestring($model->attributes['name']);

            $model->attributes['unique_id'] = uniqid();

            $model->attributes['token'] = Helper::generate_token();

            $model->attributes['token_expiry'] = Helper::generate_token_expiry();

            $model->attributes['latitude'] = 0.00;

            $model->attributes['longitude'] =0.00;
            
            if(in_array($model->login_by, ['facebook' , 'google'])) {
                
                $model->attributes['password'] = \Hash::make($model->attributes['social_unique_id']);
            }

        });

        static::created(function($model) {

            $model->attributes['unique_id'] = "UID"."-".$model->attributes['id']."-".uniqid();

            $model->attributes['token'] = Helper::generate_token();

            $model->attributes['token_expiry'] = Helper::generate_token_expiry();

            $model->save();
       
        });

        static::updating(function($model) {

            $model->attributes['username'] = routefreestring($model->attributes['name']);

            $model->attributes['first_name'] = $model->attributes['last_name'] = $model->attributes['name'];

        });

        static::deleting(function ($model) {

            Helper::delete_file($model->picture , PROFILE_PATH_PROVIDER);

            $model->spaces()->delete();

            $model->bookings()->delete();

            $model->providersreview()->delete();

            $model->usersreview()->delete();

            $model->booking_payment_provider()->delete();

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

        $this->attributes['is_verified'] = 0;

        return true;
    
    }

    public function spaces() {

        return $this->hasMany('App\Space');
    }

    public function bookings() {

        return $this->hasMany('App\Booking');
    }

    public function providersreview() {

        return $this->hasMany('App\BookingProviderReview');
    }

    public function usersreview() {

        return $this->hasMany('App\BookingUserReview');
    }
    public function booking_payment_provider() {

        return $this->hasMany('App\BookingPayment');
    }
}
