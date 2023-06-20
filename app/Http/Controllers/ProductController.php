<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index() {
        foreach (Product::all() as $product) {
            $products[] = array(
                'title' => $product->title,
                'category' => $product->category,
                'price' => $product->price,
                'description' => $product->description,
            );
        }

        return response()->json([
            'message' => 'Get products success!',
            'data' => $products
        ], 200);
    }

    public function show($id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'message' => 'Get products success!',
            'data' => $product
        ], 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            Product::create([
                'title' => $request->title,
                'category' => $request->category,
                'price' => $request->price,
                'description' => $request->description,
            ]);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to create product :' . $e->errorInfo], 500);
        }

        return response()->json(['message' => 'Create Product Successfully...'], 201);
    }

    public function update(Request $request, $id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $product->update([
                'title' => $request->title,
                'category' => $request->category,
                'price' => $request->price,
                'description' => $request->description,
            ]);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to update product :' . $e->errorInfo], 500);
        }

        return response()->json(['message' => 'Update Product Successfully...'], 200);
    }

    public function destroy($id) {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        try{
            $product->delete();
        } catch(QueryException $e){
            return response()->json(['error' => 'Failed to delete product :' . $e->errorInfo], 500);
        }

        return response()->json(['message' => 'Delete Product Successfully!'], 200);
    }
}
