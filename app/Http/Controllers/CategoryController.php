<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cat_name' => 'required|string|max:255',
            'cat_code' => 'required|string|unique:categories,cat_code|max:50',
        ], [
            'cat_name.required' => 'The Category Name field is required.',
            'cat_code.required' => 'The Category Code field is required.',
            'cat_code.unique' => 'The Category Code must be unique.',
        ]);

        Category::create($validatedData);

        return redirect('/category')->with('success', 'Category has been added');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'cat_name' => 'required|string|max:255',
            'cat_code' => 'required|string|unique:categories,cat_code,' . $id . '|max:50',
        ]);

        Category::findOrFail($id)->update($validatedData);
        return redirect('/category')->with('success', 'Category has been updated');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect('/category')->with('success', 'Category has been deleted');
    }
}