<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        return Customer::all();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'first_name' => 'required|unique:customers',
            'last_name' => 'required',
            'phone' => 'nullable|string|max:10',
            'email' => 'required|email',
            'address' => 'nullable',
        ]);
        return Customer::create($validated);
    }

    public function show($id) {
        return Customer::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $customer = Customer::findOrFail($id);
        $customer->update($request->only(['first_name', 'last_name', 'phone', 'email', 'address']));
        return $customer;
    }

    public function destroy($id) {
        return response()->json(['deleted' => Customer::destroy($id)]);
    }
}
