<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logic to retrieve and display users
        $users = User::whereHas('role', function ($query) {
            $query->where('role_name', '!=', 'customer');
        })->orderBy('fullname', 'asc')->get();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('role_name', '!=', 'customer')->orderBy('role_name', 'asc')->get();

        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'fullname' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'phone' => 'required|string|max:20',
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:8|confirmed',
                'role_id' => 'required|exists:roles,id',
            ],
            [
                'fullname.required' => 'Nama karyawan harus diisi.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'phone.required' => 'Nomor telepon harus diisi.',
                'username.required' => 'Username harus diisi.',
                'username.unique' => 'Username sudah terdaftar.',
                'password.required' => 'Password harus diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password_confirmation.required' => 'Konfirmasi password harus diisi.',
                'password_confirmation.min' => 'Konfirmasi password minimal 8 karakter.',
                'password_confirmation.same' => 'Konfirmasi password harus sama dengan password.',
                'role_id.required' => 'Role harus dipilih.',
                'role_id.exists' => 'Role yang dipilih tidak valid.',
            ]
        );

        // Hash the password before saving
        $validated['password'] = Hash::make($validated['password']);

        // Create a new user

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
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
        $user = User::findOrFail($id);

        $roles = Role::where('role_name', '!=', 'customer')->orderBy('role_name', 'asc')->get();

        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $validated = $request->validate(
            [
                'fullname' => 'required|string|max:255',
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'phone' => 'required|string|max:20',
                'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'confirmed',
                    function ($attribute, $value, $fail) use ($user) {
                        if (Hash::check($value, $user->password)) {
                            $fail('Password baru harus berbeda dari password saat ini.');
                        }
                    }
                ],
                'role_id' => 'required|exists:roles,id',
            ],
            [
                'fullname.required' => 'Nama karyawan harus diisi.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'phone.required' => 'Nomor telepon harus diisi.',
                'username.required' => 'Username harus diisi.',
                'username.unique' => 'Username sudah terdaftar.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password_confirmation.required_with' => 'Konfirmasi password harus diisi jika password diubah.',
                'password_confirmation.min' => 'Konfirmasi password minimal 8 karakter.',
                'password_confirmation.same' => 'Konfirmasi password harus sama dengan password.',
                'role_id.required' => 'Role harus dipilih.',
                'role_id.exists' => 'Role yang dipilih tidak valid.',
            ]
        );
        // Hash password jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
            unset($validated['password_confirmation']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Soft delete the user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
