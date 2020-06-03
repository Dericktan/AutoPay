<?php

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Http\Request;
use App\Http\Requests\VendorRequest;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::all();
        return response()->json([
            "data" => $vendors,
            "message" => "All vendors"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
        try {
            
            $vendor = Vendor::create($request->all());
            if ($vendor) {
                return response()->json([
                    "data" => $vendor,
                    "message" => "Vendor successfully created"
                ], 200);
            } else {
                return response()->json([
                    "data" => [],
                    "message" => "There is an errors when creating the vendor"
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
    public function show(Vendor $vendor)
    {
        try {
            return response()->json([
                "data" => $vendor,
                "message" => "Vendor successfully showed"
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
    public function update(VendorRequest $request, Vendor $vendor)
    {
        try {
            $vendor->fill($request->all());

            if ($vendor->save()) {
                return response()->json([
                    "data" => $vendor,
                    "message" => "Vendor successfully updated"
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
    public function destroy(Vendor $vendor)
    {
        try {

            if ($vendor->delete()) {
                return response()->json([
                    "data" => $vendor,
                    "message" => "Vendor successfully deleted"
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
