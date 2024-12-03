<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    //
    protected $fillable =[
        'from_time',
        'to_time',
        'reservation_date',
        'num_guest',
        'customer_id',
        'status'

    ];
}
