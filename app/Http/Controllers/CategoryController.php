<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $title = "Quản lý danh mục";
        $categories = Category::with('courses')->get();
        return view('admin.category.index', compact('categories', 'title'));
    }

    public function indexTeacher()
    {
        $title = "Quản lý danh mục";
        $categories = Category::with('courses')->get();
        return view('teacher.category.index', compact('categories', 'title'));
    }
    public function create()
    {
        return view('admin.category.create');
    }

    public function createTeacher()
    {
        return view('teacher.category.create');
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

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        Category::create($request->all());
        return redirect()->route('teacher.category.index')->with('success', 'Category created successfully.');
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

    public function editTeacher($id)
    {
        $categories = Category::findOrFail($id);
        return view('teacher.category.edit', compact('categories'));
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

    public function updateTeacher(Request $request, $id)
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
        return redirect()->route('teacher.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
    }

    public function destroyTeacher(Category $category)
    {
        $category->delete();
        return redirect()->route('teacher.category.index')->with('success', 'Category deleted successfully.');
    }
}
