<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return Category::all();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'nullable',
        ]);
        return Category::create($validated);
    }

    public function show($id) {
        return Category::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);
        $category->update($request->only(['name', 'description']));
        return $category;
    }

    public function destroy($id) {
        return response()->json(['deleted' => Category::destroy($id)]);
    }
}
