<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        $validator = Validator::make($request->all(), [
            'table_id' => ['required','exists:tables,id'],
            'waiter_id' => ['required','exists:waiters,id'],
            'reservation_id'=>['required','exists:reservations,id'],
            'customer_id'=>['required','exists:customers,id'],
            'meals'=>['required','array'],
            'meals.*.meal_id'=>['required','exists:meals,id'],
            'meals.*.num_meals'=>['required','numeric'],

        ], [
            'table_id.required' => 'table is required.',
            'table_id.exists' => 'this table not exists in our systems.',
            'waiter_id.required' => 'waiter is required.',
            'waiter_id.exists' => 'this waiter not exists in our systems.',
            'reservation_id.required' => 'reservation is required.',
            'reservation_id.exists' => 'this reservation not exists in our systems.',
            'customer_id.required'=>'customer is required',
            'customer_id.exists'=>'this customer not exists in our system add it.'
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        $order = Order::create([
            'table_id' => $request->table_id,
            'reservation_id' => $request->reservation_id,
            'customer_id' => $request->customer_id,
            'waiter_id' => $request->waiter_id,
            'total' => 0.0,
            'paid' => false,
        ]);

        $total = 0.0;
        if($request->has('meals')){
            foreach($request->meals as $meal){
                $meal_price = DB::table('meals')->find($meal['meal_id']);
                $amount_to_pay = ($meal['num_meals'] * ($meal_price->price - ($meal_price->price * $meal_price->discount)/100));
                $total += $amount_to_pay;
                OrderDetail::create([
                    'amount_to_pay'=>$amount_to_pay,
                    'num_meals'=>$meal['num_meals'],
                    'meal_id'=>$meal['meal_id'],
                    'order_id'=>$order->id,
                ]);

            }
        }
        $order->total = $total;
        $order->save();

        return response()->json(["message" => "order done."], 400);


    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
