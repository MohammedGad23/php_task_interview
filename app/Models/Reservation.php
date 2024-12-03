<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    protected $fillable =[
        'from_time',
        'to_time',
        'reservation_date',
        'table_id',
        'customer_id',
    ];

    public function customerReservation(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function tableReservation(){
        return $this->hasMany(Table::class,'id','table_id');
    }

}
