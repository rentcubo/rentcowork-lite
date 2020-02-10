<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingUserReview extends Model
{
    public function users(){

    	return $this->belongsTo('App\User','user_id');

    }

    public function providers(){

    	return $this->belongsTo('App\Provider','provider_id');
    	
    }

    public function bookings(){

    	return $this->belongsTo('App\Booking');
    	
    } 

    public function spaces(){
      
        return $this->belongsTo('App\Space');

    } 
}
