@extends('admin.layouts.master')

@section('title', 'Edit Karyawan')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Karyawan</h3>
                    <p class="text-subtitle text-muted">Silahkan Isi Data Karyawan Yang Ingin Diubah</p>
                </div>
            </div>
        </div>
        <div class="page-content">
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                {{-- Nama Karyawan --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="fullname" class="form-label fw-bold">Nama Karyawan</label>
                                        <input type="text" name="fullname" id="fullname" value="{{ old('fullname', $user->fullname) }}"
                                            class="form-control @error('fullname') is-invalid @enderror"
                                            placeholder="Masukkan nama produk">
                                        @error('fullname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="email" class="form-label fw-bold">Email</label>
                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Masukkan email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Nomor Telepon --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="phone" class="form-label fw-bold">Nomor Telepon</label>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="Masukkan nomor telepon">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Username --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="username" class="form-label fw-bold">Username</label>
                                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                                            class="form-control @error('username') is-invalid @enderror"
                                            placeholder="Masukkan username">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="password" class="form-label fw-bold">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Masukkan password">
                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                data-target="password">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="password_confirmation" class="form-label fw-bold">Konfirmasi
                                            Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                placeholder="Konfirmasi password">
                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                data-target="password_confirmation">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                {{-- Role --}}
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="role_id" class="form-label fw-bold">Role</label>
                                        <select name="role_id" id="role_id"
                                            class="form-select @error('role_id') is-invalid @enderror">
                                            <option value="" selected disabled>-- Pilih Role --</option>
                                            @foreach ($roles as $role)
                                                @if (strtolower($role->role_name) !== 'customer')
                                                    <option value="{{ $role->id }}"
                                                    {{ old('role_id') == $role->id ? 'selected' : '' }} {{$user->role_id == $role->id ? 'selected' : ''}}>
                                                        {{ $role->role_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-sm btn-success btn-flat">
                                    <i class="bi bi-save"></i>
                                    Simpan
                                </button>
                                <button type="reset" class="btn btn-sm btn-danger ms-2">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                    Reset
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-warning btn-sm ms-2">
                                    <i class="bi bi-arrow-left"></i>
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-password');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            });
        });
    </script>


@endsection
