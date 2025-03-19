<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        $title = 'Quản lí danh mục';
        return view('admin.category.index', compact('title', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm danh mục';
        return view('admin.category.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục',
            'image.required' => 'Vui lòng chọn hình ảnh',
            'image.max' => 'hình ảnh vượt quá dungg lượng cho phép',
        ]);
        $imagePath = $request->file('image')->store('categories', 'public');
        $slug = Str::slug($request->name);

        Categories::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $slug,
            'image' => $imagePath ?? null,
        ]);
        return redirect()->route('admin.category.index')->with('success', 'Thêm danh mục thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Sửa danh mục';
        $categories = Categories::find($id);
        return view('admin.category.edit', compact('title', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categories = Categories::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $categories->image = $imagePath;
        }

        $categories->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);
        return redirect()->route('admin.category.index')->with('success', 'Sửa danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $categories = Categories::findOrFail($id);
        $categories->delete();
        return redirect()->route('admin.category.index')->with('success', 'Xóa danh mục thành công');
    }
}
