<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\WaitingList;
class ReservationController extends Controller
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
    public function checkAvailability(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'number_of_guests' => ['required','numeric','min:1'],
            'reservation_date'=>['required','date'],
        ], [
            'number_of_guests.required' => 'The number of guests is required.',
            'number_of_guests.integer' => 'The number of guests must be integer.',
            'number_of_guests.min' => 'The number of guests must be atleast 1.',
            'reservation_date.required' => 'The reservation date is required.',
            'reservation_date.date' => 'The reservation date must be a valid date.',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }
        if($request->has('customer_id')){
            // for store reservation function
            $reservedTableIds = DB::table('reservations')
                    ->where('reservation_date', $request->reservation_date)
                    ->where('from_time','>=',$request->from_time)
                    ->pluck('table_id');
        }else{
            $reservedTableIds = DB::table('reservations')
                ->where('reservation_date', $request->reservation_date)
                ->pluck('table_id');
        }

        $find_table = DB::table('tables')
            ->where('capacity', '>=', $request->number_of_guests)
            ->whereNotIn('id', $reservedTableIds)
            ->orderBy('capacity', 'asc')
            ->first();


        if($request->has('customer_id')){
            // this condition for store reservation.
            if(!$find_table){
                return -1;
            }
            return $find_table->id;
        }
        if(!$find_table){
            return response()->json(["message" => "no table exist for this number_of_guests"], 400);
        }
        return response()->json([
            "message" => "table exist for this number_of_guests",
            "table id is "=>$find_table->id
        ],  200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'number_of_guests' => ['required','numeric','min:1'],
            'from_time' => ['required'],//'date_format:H:i'],
            'to_time' => ['required'],//'date_format:H:i','after:from_time'],
            'reservation_date'=>['required','date'],
            'customer_id'=>['required','exists:customers,id'],
        ], [
            'number_of_guests.required' => 'The number of guests is required.',
            'number_of_guests.integer' => 'The number of guests must be integer.',
            'number_of_guests.min' => 'The number of guests must be atleast 1.',
            'from_time.required' => 'The start time is required.',
            'from_time.date_format' => 'The start time must be in the format HH:mm.',
            'to_time.required' => 'The end time is required.',
            'to_time.date_format' => 'The end time must be in the format HH:mm.',
            'to_time.after' => 'The end time must be after the start time.',
            'reservation_date.required' => 'The reservation date is required.',
            'reservation_date.date' => 'The reservation date must be a valid date.',
            'customer_id.required'=>'customer is required',
            'customer_id.exists'=>'this customer not exists in our system add it.'
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        $table_id = $this->checkAvailability($request);
        if($table_id == -1){
            $reservation = WaitingList::create([
                'from_time'=>$request->from_time,
                'to_time'=>$request->to_time,
                'reservation_date'=>$request->reservation_date,
                'customer_id'=>$request->customer_id,
                'num_guest'=>$request->number_of_guests,
                'status'=>'waiting',
            ]);
            return response()->json([
                "message" => "no table exist for this number_of_guests",
                "waiting list"=> "we will added you to witing list."
            ], 200);
        }
        $reservation = Reservation::create([
            'from_time'=>$request->from_time,
            'to_time'=>$request->to_time,
            'reservation_date'=>$request->reservation_date,
            'table_id'=>$table_id,
            'customer_id'=>$request->customer_id,
        ]);

        return $reservation;
    }


    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
