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

    public function customerOrder(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function orderWaiter(){
        return $this->belongsTo(Waiter::class,'waiter_id');
    }

    public function mealOrder(){
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }
}
