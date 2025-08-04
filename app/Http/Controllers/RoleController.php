<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logic to retrieve and display roles
        $roles = Role::all(); // Assuming Role model exists
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show the form to create a new role
        return view('admin.role.create');   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'role_name' => 'required|string|max:255|unique:roles,role_name',
            'description' => 'required|string',
        ], [
            'role_name.required' => 'Nama role harus diisi.',
            'role_name.max' => 'Nama role tidak boleh lebih dari 255 karakter.',
            'role_name.string' => 'Nama role harus berupa teks.',
            'role_name.unique' => 'Nama role sudah ada.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        // Create a new role
        Role::create($validator);

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
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
        $role = Role::findOrFail($id); // Assuming Role model exists
        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $validator = $request->validate([
            'role_name' => 'required|string|max:255|unique:roles,role_name,' . $role->id,
            'description' => 'required|string',
        ], [
            'role_name.required' => 'Nama role harus diisi.',
            'role_name.max' => 'Nama role tidak boleh lebih dari 255 karakter.',
            'role_name.string' => 'Nama role harus berupa teks.',
            'role_name.unique' => 'Nama role sudah ada.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        // Update the role
        $role->update($validator);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        if (!$role) {
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
