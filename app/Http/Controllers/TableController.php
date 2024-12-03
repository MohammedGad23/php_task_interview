<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TableResource;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $tables = DB::table('tables')->get();
        return TableResource::collection($tables);
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
            'capacity'=>['required','numeric']

        ], [
            'capacity.required'=>'pls sent capacity of table.',
            'capacity.numeric' => 'capacity must be a numeric.',
      ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        Table::create($request->all());

        return response()->json([
            'message' => 'success added a new table.'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($table)
    {
        //
        $table_ = DB::table('tables')->find($table);
        if(!$table_){
            return response()->json(["message" => "this table not exist in system."], 400);
        }

        return new TableResource($table_);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $table)
    {
        //

        $table_ = Table::find($table);
        if(!$table_){
            return response()->json(["message" => "this table not exist in system."], 400);
        }

        $validator = Validator::make($request->all(), [
            'capacity'=>['required','numeric']

        ], [
            'capacity.required'=>'pls sent capacity of table.',
            'capacity.numeric' => 'capacity must be a numeric.',
      ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], 400);
        }

        $table_->capacity = $request->capacity??$table_->capacity;

        $table_->save();

        return response()->json([
            'message' => 'success update table.'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        //
    }
}
