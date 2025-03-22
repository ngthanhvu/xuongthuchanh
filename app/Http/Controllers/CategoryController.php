<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('courses')->get();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        Category::create($request->all());
        return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $category->load('courses');
        return view('admin.category.show', compact('category'));
    }

    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return view('admin.category.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $categories = Category::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);
        
        $categories->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
    }
}
