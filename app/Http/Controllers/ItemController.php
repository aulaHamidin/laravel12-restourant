<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logic to retrieve and display items
        $items = Item::orderBy('item_name', 'asc')->get(); // Assuming Item model exists
        return view('admin.item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('cat_name', 'asc')->get(); 
        return view('admin.item.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],
        [
            'item_name.required' => 'Nama item harus diisi.',
            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'item_name.max' => 'Nama item tidak boleh lebih dari 255 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'image.mimes' => 'Gambar harus berupa file dengan format jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'item_name.string' => 'Nama item harus berupa teks.',
            'category_id.required' => 'Kategori harus dipilih.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
        ]
    );

        $item = new Item();
        $item->item_name = $request->input('item_name');
        $item->description = $request->input('description');
        $item->price = $request->input('price');
        $item->category_id = $request->input('category_id');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('assets/img_item', 'public');
            $item->image = $imagePath;
        }

        $item->save();

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
