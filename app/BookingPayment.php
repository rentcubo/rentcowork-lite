<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paid_amount', 'paid_date', 'status',
    ];

    public function users() {

    	return $this->belongsTo('App\User','user_id');
    } 

    public function spaces() {

    	return $this->belongsTo('App\Space','space_id');
    } 

    public function providers() {

    	return $this->belongsTo('App\Provider','provider_id');

    } 

    public function bookings() {

    	return $this->belongsTo('App\Booking','booking_id');
    }

    public static function boot() {

        parent::boot();

         static::creating(function ($model) {

            $unique_id = uniqid()."-".strtotime(date('Y-m-d H:i:s'));

            $model->payment_id = "P-".routefreestring($unique_id);

        });

    }
}
