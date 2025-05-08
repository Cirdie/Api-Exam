<?php

namespace App\Http\Controllers;

use App\Models\SalesItem;
use Illuminate\Http\Request;

class SalesItemController extends Controller
{
    public function index() {
        return SalesItem::with(['product', 'sale'])->get();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,sale_id',
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'subtotal' => 'required|numeric',
        ]);
        return SalesItem::create($validated);
    }

    public function show($id) {
        return SalesItem::with(['product', 'sale'])->findOrFail($id);
    }

    public function update(Request $request, $id) {
        $item = SalesItem::findOrFail($id);
        $item->update($request->only(['quantity', 'price', 'subtotal']));
        return $item;
    }

    public function destroy($id) {
        return response()->json(['deleted' => SalesItem::destroy($id)]);
    }
}
