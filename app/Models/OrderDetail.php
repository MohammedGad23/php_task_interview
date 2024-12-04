<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    public $timestamps=false;
    protected $fillable =[
        'amount_to_pay',
        'num_meals',
        'meal_id',
        'order_id',
    ];

    public function meal(){
        return $this->belongsTo(Meal::class,'meal_id');
    }
}
