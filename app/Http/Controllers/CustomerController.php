<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customers = DB::table('customers')->get();
        return CustomerResource::collection($customers);

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
            'phone' => ['required','min:12','regex:/^\+?[0-9]{10,15}$/', 'unique:customers'],
        ], [
            'name.required' => 'name is required.',
            'name.min' => 'min of name must be 12 chars.',
            'phone.required' => 'phone number is required.',
            'phone.min' => 'min of phone must be 12 digit.',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        Customer::create($request->all());

        return response()->json([
            'message' => 'success added.'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($customer)
    {
        //
        $customer_ = DB::table('customers')->find($customer);
        if(!$customer_){
            return response()->json(["message" => "this customer not exist in system."], 400);
        }
        return new CustomerResource($customer_);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $customer)
    {
        //
        $customer_ = Customer::find($customer);
        if(!$customer_){
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
        $customer_->name = $request->name??$customer_->name;
        $customer_->phone = $request->phone??$customer_->phone;
        // return 1;
        $customer_->save();
        return response()->json([
            'message' => 'success updated.'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
