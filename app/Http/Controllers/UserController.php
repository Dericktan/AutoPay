<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            "data" => $users,
            "message" => "All users"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $request->all();
            $data["password"] = bcrypt($request->password);
            $data["balance"] = 0;

            $user = User::create($data);

            if ($user) {
                return response()->json([
                    "data" => $user,
                    "message" => "User successfully created"
                ], 200);
            } else {
                return response()->json([
                    "data" => [],
                    "message" => "There is an errors when creating the user"
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
    public function show(User $user)
    {
        try {
            return response()->json([
                "data" => $user,
                "message" => "User successfully showed"
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
    public function update(UserRequest $request, User $user)
    {
        try {
            $user->fill($request->all());

            if ($user->save()) {
                return response()->json([
                    "data" => $user,
                    "message" => "User successfully updated"
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
    public function destroy(User $user)
    {
        try {

            if ($user->delete()) {
                return response()->json([
                    "data" => $user,
                    "message" => "User successfully deleted"
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
