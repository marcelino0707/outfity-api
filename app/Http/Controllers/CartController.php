<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->first();

            if($cart) {
                $cart->quantity += $request->quantity;
                $cart->save();
            } else {
                $cart = Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            }
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to create cart :' . $e->errorInfo], 500);
        }

        return response()->json(['message' => 'Create Cart Successfully...'], 201);
    }
}
