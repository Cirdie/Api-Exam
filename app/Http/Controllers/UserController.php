<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        $allowedRoles = ['M', 'C', 'A', 'S'];

        $inputRole = $request->input('role');
        $validated['role'] = in_array($inputRole, $allowedRoles) ? $inputRole : 'C';

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function show($id) {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $data = $request->only(['username', 'password', 'role']);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['role']) && !in_array($data['role'], ['M', 'C', 'A', 'S'])) {
            $data['role'] = 'C';
        }

        $user->update($data);

        return response()->json($user);
    }

    public function destroy($id) {
        return response()->json(['deleted' => User::destroy($id)]);
    }

    public function sortedDesc() {
        return User::orderBy('created_at', 'desc')->get();
    }

    public function byRole($role) {
        return User::where('role', $role)->get();
    }

    public function byUsername($username) {
        return User::where('username', $username)->get();
    }


    public function countByRole($role = null)
    {
        if ($role) {
            $count = User::where('role', $role)->count();
            return response()->json([
                'role' => $role,
                'count' => $count
            ]);
        } else {
            $count = User::count();
            return response()->json([
                'role' => 'ALL',
                'count' => $count
            ]);
        }
    }



}
