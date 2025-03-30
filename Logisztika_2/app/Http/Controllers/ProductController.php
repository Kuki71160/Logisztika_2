<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response(json_encode(['succes' => true, 'products' => $products]));
    }

    public function store(Request $request){
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'supplier_id' => 'required|exists:suppliers,id',
                'quantity' => 'required|integer|min:0',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
                'stock' => 'required|integer|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }
        

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'image' => $request->image,
            'stock' => $request->stock,
        ]);

        return response(json_encode(['succes' => true, 'product' => $product]));
    }

    public function destroy($id){
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false, 'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true, 'message' => 'Product deleted successfully'
        ]);
    }
}
