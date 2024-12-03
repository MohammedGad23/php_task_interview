<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

use App\Http\Resources\MealResource;
use Illuminate\Support\Facades\DB;
class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customers = DB::table('meals')->get();
        return MealResource::collection($customers);
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
            'name'=>['required','string'],
            'price' => ['required', 'numeric'],
            'description' => ['required'],
            'quantity_available' => ['required','numeric'],
            'discount' => ['required','numeric'],

        ], [
            'name.required'=>'pls sent name of meal.',
            'price.required' => 'pls sent price.',
            'price.numeric' => 'price must be numeric.',
            'description.required' => 'description is required.',
            'quantity_available.required' => 'quantity available should be send.',
            'quantity_available.numeric' => 'quantity available should be numeric.',
            'discount.numeric' => 'discount should be numeric and from 0 to 100.',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        Meal::create($request->all());

        return response()->json([
            'message' => 'success added a new meal.'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($meal)
    {
        //
        $meal_ = DB::table('meals')->find($meal);
        if(!$meal_){
            return response()->json(["message" => "this customer not exist in system."], 400);
        }

        return new MealResource($meal_);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $meal)
    {
        //
        $meal_ = Meal::find($meal);
        if(!$meal_){
            return response()->json(["message" => "this customer not exist in system."], 400);
        }

        $validator = Validator::make($request->all(), [
            'price' => ['nullable', 'numeric'],
            'description' => ['nullable'],
            'quantity_available' => ['nullable','numeric'],
            'discount' => ['nullable','numeric'],

        ], [
            'price.required' => 'pls sent price.',
            'price.numeric' => 'price must be numeric.',
            'description.required' => 'description is required.',
            'quantity_available.required' => 'quantity available should be send.',
            'quantity_available.numeric' => 'quantity available should be numeric.',
            'discount.numeric' => 'discount should be numeric and from 0 to 100.',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        $meal_->price = $request->price?? $meal_->price;
        $meal_->description = $request->description?? $meal_->description;
        $meal_->quantity_available = $request->quantity_available?? $meal_->quantity_available;
        $meal_->discount = $request->discount?? $meal_->discount;
        $meal_->save();

        return response()->json([
            'message' => 'success updated meal.'
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
