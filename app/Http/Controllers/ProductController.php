<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            "data" => $products,
            "message" => "All products"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            
            $product = Product::create($request->all());
            if ($product) {
                return response()->json([
                    "data" => $product,
                    "message" => "Product successfully created"
                ], 200);
            } else {
                return response()->json([
                    "data" => [],
                    "message" => "There is an errors when creating the product"
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
    public function show(Product $product)
    {
        try {
            return response()->json([
                "data" => $product,
                "message" => "Product successfully showed"
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
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $product->fill($request->all());

            if ($product->save()) {
                return response()->json([
                    "data" => $product,
                    "message" => "Product successfully updated"
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
    public function destroy(Product $product)
    {
        try {

            if ($product->delete()) {
                return response()->json([
                    "data" => $product,
                    "message" => "Product successfully updated"
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
