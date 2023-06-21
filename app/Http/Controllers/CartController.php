<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function getCart()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)
            ->get()
            ->map(function($carts) {
                return [
                    'id' => $carts->id,
                    'title_cart' => $carts->title_cart,
                    'updated_at' => $carts->updated_at,
                ];   
            });

        if (!$carts) {
            return response()->json(['error' => 'Carts is empty'], 404);
        }
            
        return response()->json([
            'message' => 'Get carts success!',
            'data' => $carts
        ], 200);
    }

    public function createCart(Request $request) {
        $validator = Validator::make($request->all(), [
            'title_cart' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $user = Auth::user();
        
            Cart::create([
                'user_id' =>  $user->id,
                'title_cart' => $request->title_cart,
            ]);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to create new cart :' . $e->errorInfo], 500);
        }

        return response()->json(['message' => 'Create Cart Successfully...'], 201);
    }
    public function showCartItem($id) {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $items = CartDetail::where('cart_id', $cart->id)
            ->with('product')
            ->get()
            ->map(function ($items) {
                return [
                    'title' => $items->product->title,
                    'price' => $items->product->price,
                    'category' => $items->product->category,
                    'description' => $items->product->description,
                    'quantity' => $items->quantity,
                ];
            });
            
        return response()->json([
            'message' => 'Get cart detail success!',
            'data' => $items
        ], 200); 
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $user = Auth::user();

            $cart = Cart::where('user_id', $user->id)
                ->where('id', $request->cart_id)
                ->first();

            if (!$cart) {
                return response()->json(['error' => 'Cart not found'], 404);
            }

            $cart = CartDetail::where('cart_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->first();

            if($cart) {
                $cart->quantity += $request->quantity;
                $cart->save();
            
            } else {
                $cart = CartDetail::create([
                    'cart_id' => $request->cart_id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            }
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to add item to cart :' . $e->errorInfo], 500);
        }

        return response()->json(['message' => 'Add item to cart successfully...'], 201);
    }

    public function checkout(Request $request) {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|exists:carts,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)
            ->where('id', $request->cart_id)    
            ->first();

        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $total_amount = 0;

        $products = CartDetail::where('cart_id', $cart->id)
            ->with('product')
            ->get();

        foreach ($products as $product) {
            $total_per_item = 0;
            $total_per_item = $product->quantity * $product->product->price;
            $total_amount = $total_amount + $total_per_item;
        }

        try {
            Transaction::create([
                'cart_id' =>  $cart->id,
                'invoice_number' => 'INV-'. uniqid($cart->id),
                'total_amount' => $total_amount,
            ]);

            $cart->delete();
            
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to create transaction :' . $e->errorInfo], 500);
        }

        return response()->json(['message' => 'Create Transaction Successfully...'], 201);
    }
}
