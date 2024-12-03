<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    protected $fillable =[
        'amount_to_pay',
        'num_meals',
        'meal_id',
        'order_id',
    ];
}
