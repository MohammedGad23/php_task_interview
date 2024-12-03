<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Waiter;
use App\Http\Resources\WaiterResource;
use Illuminate\Http\Request;

class WaiterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $waiters = DB::table('waiters')->get();
        return WaiterResource::collection($waiters);
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
            'name' => ['required', 'string', 'min:10'],
            'phone' => ['required','min:12','regex:/^\+?[0-9]{10,15}$/', 'unique:waiters'],
        ], [
            'name.required' => 'name is required.',
            'name.min' => 'min of name must be 12 chars.',
            'phone.required' => 'phone number is required.',
            'phone.min' => 'min of phone must be 12 digit.',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        Waiter::create($request->all());

        return response()->json([
            'message' => 'success added a new Waiter.'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($waiter)
    {
        //
        $waiter_ = DB::table('waiters')->find($waiter);
        if(!$waiter_){
            return response()->json(["message" => "this waiter not exist in system."], 400);
        }

        return new WaiterResource($waiter_);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Waiter $waiter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $waiter)
    {
        //
        $waiter_ = Waiter::find($waiter);
        if(!$waiter_){
            return response()->json(["message" => "this customer not exist in system."], 400);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'min:12'],
            'phone' => ['nullable','min:12','regex:/^\+?[0-9]{10,15}$/'],
        ], [
            'name.min' => 'min of name must be 12 chars.',
            'phone.min' => 'min of phone must be 12 digit.',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }
        $waiter_->name = $request->name??$waiter_->name;
        $waiter_->phone = $request->phone??$waiter_->phone;
        $waiter_->save();
        
        return response()->json([
            'message' => 'success updated.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Waiter $waiter)
    {
        //
    }
}
