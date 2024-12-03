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
}
