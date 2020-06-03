<?php

namespace App\Http\Controllers;

use App\Counter;
use Illuminate\Http\Request;
use App\Http\Requests\CounterRequest;

class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counters = Counter::all();
        return response()->json([
            "data" => $counters,
            "message" => "All counters"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CounterRequest $request)
    {
        try {
            
            $counter = Counter::create($request->all());
            if ($counter) {
                return response()->json([
                    "data" => $counter,
                    "message" => "Counter successfully created"
                ], 200);
            } else {
                return response()->json([
                    "data" => [],
                    "message" => "There is an errors when creating the counter"
                ], 500);
            }

        } catch (\Throwable $th) {
            return response()->json([
                "data" => [],
                "message" => "There is something wrong!"
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Counter $counter)
    {
        try {
            return response()->json([
                "data" => $counter,
                "message" => "Counter successfully showed"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "data" => [],
                "message" => "There is something wrong"
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CounterRequest $request, Counter $counter)
    {
        try {
            $counter->fill($request->all());

            if ($counter->save()) {
                return response()->json([
                    "data" => $counter,
                    "message" => "Counter successfully updated"
                ], 200);
            } else {
                return response()->json([
                    "data" => [],
                    "message" => "There is an errors when updating the product"
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "data" => [],
                "message" => "There is something wrong"
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Counter $counter)
    {
        try {

            if ($counter->delete()) {
                return response()->json([
                    "data" => $counter,
                    "message" => "Counter successfully deleted"
                ], 200);
            } else {
                return response()->json([
                    "data" => [],
                    "message" => "There is an errors when deleting the product"
                ], 500);
            }

        } catch (\Throwable $th) {
            return response()->json([
                "data" => [],
                "message" => "There is something wrong"
            ], 500);
        }
    }
}
