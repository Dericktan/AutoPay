<?php

namespace App\Http\Controllers;

use App\User;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json([
            "data" => $transactions,
            "message" => "All transaction"
        ], 200);
    }

    /**
     * Display the specified resource filtered by user specified.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function byUser(User $user)
    {
        $transactions = Transaction::where('user_id', $user->id)->get();
        return response()->json([
            "data" => $transactions,
            "message" => "All transaction for user " . $user->name
        ], 200);
    }
}
