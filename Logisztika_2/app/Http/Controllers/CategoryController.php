<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    // Get all categories
    public function index()
    {
        $categories = Category::all();
        return response()->json(['success' => true, 'categories' => $categories]);
    }

    // Create a new category
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json(['success' => true, 'category' => $category]);
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted']);
    }
}
