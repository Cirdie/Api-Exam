<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        return Product::create($validated);
    }

    public function show($id)
    {
        return Product::with('category')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|unique:products,name,' . $id,
            'description' => 'sometimes|string|nullable',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'category_id' => 'sometimes|exists:categories,category_id',
        ]);

        $product->update($validated);

        return response()->json($product);
    }

    public function destroy($id)
    {
        return response()->json(['deleted' => Product::destroy($id)]);
    }

    public function averageProductPrice()
    {
        $avg = DB::table('products')->avg('price');

        return response()->json([
            'average_price' => round($avg, 2)
        ]);
    }

    public function mostExpensive() {
        return Product::orderByDesc('price')->first();
    }

    public function cheapest() {
        return Product::orderBy('price')->first();
    }

    public function countByCategory($category_id = null)
    {
        if ($category_id) {
            $count = Product::where('category_id', $category_id)->count();
            return response()->json([
                'category_id' => $category_id,
                'count' => $count
            ]);
        } else {
            $count = Product::count();
            return response()->json([
                'category_id' => 'ALL',
                'count' => $count
            ]);
        }
    }

    
}
