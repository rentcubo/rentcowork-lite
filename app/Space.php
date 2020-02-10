<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Helper;

class Space extends Model
{

	public static function boot() {

        parent::boot();

	     static::creating(function ($model) {

	        $model->unique_id = uniqid(base64_encode(str_random(60)));

	    });

	     static::deleting(function ($model) {

	        $model->picture = Helper::delete_file($model->picture, FILE_PATH_SPACE);

	    });
	}

	public function provider(){

    	return $this->belongsTo('App\Provider');
    	
    } 
    public function bookings() {

        return $this->hasMany('App\Booking');
    }

}
