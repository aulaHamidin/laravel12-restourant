<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('cat_name', 'asc')->get();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'cat_name' => 'required|string|max:255|unique:categories,cat_name',
            'description' => 'nullable|string|max:255',
        ],
        [
            'cat_name.required' => 'Nama kategori harus diisi.',
            'cat_name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'cat_name.unique' => 'Nama kategori sudah ada.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            'cat_name.string' => 'Nama kategori harus berupa teks.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        Category::create([
            'cat_name'  => $validator['cat_name'],
            'description' => $validator['description'] ?? 'Tidak ada deskripsi',
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }
        
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }

        $validator = $request->validate([
            'cat_name' => 'required|string|max:255|unique:categories,cat_name,' . $id,
            'description' => 'nullable|string|max:255',
        ],
        [
            'cat_name.required' => 'Nama kategori harus diisi.',
            'cat_name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'cat_name.unique' => 'Nama kategori sudah ada.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            'cat_name.string' => 'Nama kategori harus berupa teks.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        $category->update([
            'cat_name'  => $validator['cat_name'],
            'description' => $validator['description'] ?? 'Tidak ada deskripsi',
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = category::findOrFail($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'category not found.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'category deleted successfully.');
    }
}
