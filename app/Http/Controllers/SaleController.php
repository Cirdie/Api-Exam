<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index() {
        return Sale::with(['customer', 'user'])->get();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'sale_date' => 'nullable|date',
            'total_amount' => 'required',
            'payment_method' => 'nullable|string',
            'customer_id' => 'required|exists:customers,customer_id',
            'user_id' => 'required|exists:users,user_id',
        ]);
        return Sale::create($validated);
    }

    public function show($id) {
        return Sale::with(['customer', 'user'])->findOrFail($id);
    }

    public function update(Request $request, $id) {
        $sale = Sale::findOrFail($id);
        $sale->update($request->only(['total_amount', 'payment_method', 'customer_id', 'user_id']));
        return $sale;
    }

    public function destroy($id) {
        return response()->json(['deleted' => Sale::destroy($id)]);
    }

    public function totalSalesAmount()
    {
        $total = DB::table('sales')->sum('total_amount');

        return response()->json([
            'total_sales_amount' => $total
        ]);
    }

}
