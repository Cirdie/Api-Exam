<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return Product::with('category')->get();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|unique:products',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,category_id',
        ]);
        return Product::create($validated);
    }

    public function show($id) {
        return Product::with('category')->findOrFail($id);
    }

    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'description', 'price', 'category_id']));
        return $product;
    }

    public function destroy($id) {
        return response()->json(['deleted' => Product::destroy($id)]);
    }
}
