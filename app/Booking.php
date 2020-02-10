<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    
    public static function boot() {

        parent::boot();

	     static::creating(function ($model) {

            $unique_id = uniqid()."-".strtotime(date('Y-m-d H:i:s'));

	        $model->unique_id = "B-".routefreestring($unique_id);

	    });

	}

    public function users(){

    	return $this->belongsTo('App\User','user_id');
    } 

    public function spaces(){

    	return $this->belongsTo('App\Space','space_id');
    } 

    public function providers(){

    	return $this->belongsTo('App\Provider','provider_id');

    } 

    public function bookingUserReviews() {

        return $this->hasOne('App\BookingUserReview');
    }

    public function bookingProviderReviews() {

        return $this->hasOne('App\BookingProviderReview');
    }

    public function bookingPayments() {

        return $this->hasOne('App\BookingPayment');
    }
}
