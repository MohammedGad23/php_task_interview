<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable =[
        'total',
        'paid',
        'table_id',
        'customer_id',
        'waiter_id',
        'reservation_id'
    ];
}
