<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingProviderReview extends Model
{
    //

    public function users(){

    	return $this->belongsTo('App\User','user_id');

    }

    public function providers(){

    	return $this->belongsTo('App\Provider','provider_id');
    	
    }

    public function bookings(){

    	return $this->belongsTo('App\Booking');
    	
    } 
}
