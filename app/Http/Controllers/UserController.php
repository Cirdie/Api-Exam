<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'role' => 'nullable|in:A,C',
        ]);
        return User::create($validated);
    }

    public function show($id) {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->only(['username', 'password', 'role']));
        return $user;
    }

    public function destroy($id) {
        return response()->json(['deleted' => User::destroy($id)]);
    }
}
