<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable =[
        'phone',
        'name',
    ];

    public function customerOrders(){
        return $this->hasMany(Order::class,'customer_id');
    }

    public function customerReservation(){
        return $this->hasMany(Reservation::class,'customer_id');
    }
}
