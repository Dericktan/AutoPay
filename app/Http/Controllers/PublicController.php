<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Product;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use App\Http\Requests\CardRequest;
use App\Http\Requests\CheckOutRequest;

class PublicController extends Controller
{
    /**
     * Validate card code from users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateCard(Request $request)
    {
        try {
            $count = User::where('card_code', $request->card_code)->count();
            if ($count > 0) {
                return response()->json([
                    "data" => [
                        "valid" => true
                    ],
                    "message" => "Card code is valid"
                ], 200);
            } else {
                return response()->json([
                    "data" => [
                        "valid" => false
                    ],
                    "message" => "Card code is invalid"
                ], 422);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "data" => [],
                "message" => "There is something wrong!"
            ], 500);
        }
    }

    /**
     * Validate card code from users.
     *
     * @param  App\Http\Requests\CardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticateCard(CardRequest $request)
    {
        try {
            $user = User::where('card_code', $request->card_code)->first();
            $user->makeVisible('password');
            if ($user) {
                $passwordCheck = \Hash::check($request->password, $user->password);
                if ($passwordCheck) {
                    return response()->json([
                        "data" => $user->makeHidden('password'),
                        "message" => "Card successfully verified"
                    ], 200);
                } else {
                    return response()->json([
                        "data" => [],
                        "message" => "Please check your password"
                    ], 400);
                }
            } else {
                return response()->json([
                    "data" => [
                        "valid" => false
                    ],
                    "message" => "Card code is invalid"
                ], 422);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "data" => [],
                "message" => "There is something wrong!"
            ], 500);
        }
    }

    /**
     * Checkout.
     *
     * @param  App\Http\Requests\CheckOutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function checkOut(CheckOutRequest $request) {
        try {
            $user = User::where('card_code', $request->card_code)->first();

            // Validate total price
            $carts = $request->carts;
            $total = 0;
            foreach ($carts as $cart) {
                $product = Product::where('id', $cart['product_id'])->first();

                // Check stock
                if ($product->quantity < $cart["quantity"]) {
                    return response()->json([
                        "data" => [],
                        "message" => "Stock for '" . $product->name . "' is not enough!"
                    ], 400);
                }

                $total += $cart['quantity'] * $product->price;
            }

            if ($total == $request->total) {
                if ($user->balance >= $total) {

                    // Prevent any error changes
                    DB::beginTransaction();

                    // Update user balance
                    $user->balance = $user->balance - $total;
                    $user->save();

                    // Insert into transaction
                    $transaction = Transaction::create([
                        "total" => $total,
                        "user_id" => $user->id
                    ]);

                    // Insert into trasaction detail
                    foreach ($carts as $cart) {
                        $product = Product::where('id', $cart['product_id'])->first();

                        TransactionDetail::create([
                            "price" => $product->price * $cart["quantity"],
                            "transaction_id" => $transaction->id,
                            "product_id" => $product->id,
                            "user_id" => $user->id
                        ]);
                        // Decrease the product quantity
                        $product->quantity = $product->quantity - $cart["quantity"];
                        $product->save();
                    }
                    
                    // Commit the changes
                    DB::commit();
                    
                    return response()->json([
                        "data" => $transaction,
                        "message" => "Checked out successfully"
                    ]);


                } else {
                    return response()->json([
                        "data" => [],
                        "message" => "Balance is not enough!"
                    ], 400);
                }
            } else {
                return response()->json([
                    "data" => [],
                    "message" => "Please check the total value!"
                ], 400);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
            return response()->json([
                "data" => [],
                "message" => "There is something wrong!"
            ], 500);
        }
    }

    /**
     * Top up user's balance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function topUp(Request $request) {
        try {
            if (!$request->card_code || $request->card_code == "" || !$request->amount || $request->amount < 0) {
                return response()->json([
                    "data" => [],
                    "message" => "Please send the required data!"
                ], 400);
            }

            $user = User::where('card_code', $request->card_code)->first();
            $user->balance = $user->balance + $request->amount;
            if ($user->save()) {
                return response()->json([
                    "data" => $user,
                    "message" => "Top up successfully processed"
                ], 200);
            } else {
                return response()->json([
                    "data" => [],
                    "message" => "There is something wrong when adding the amount"
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "data" => [],
                "message" => "There is something wrong!"
            ], 500);
        }
    }

}
