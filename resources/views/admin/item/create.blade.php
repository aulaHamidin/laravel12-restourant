@extends('admin.layouts.master')

@section('title', 'Tambah Item')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Produk</h3>
                    <p class="text-subtitle text-muted">Silahkan Tambahkan Item Baru</p>
                </div>
            </div>
        </div>
        <div class="page-content">
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('items.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row">
                                {{-- Nama Produk --}}
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="item_name" class="form-label fw-bold">Nama Produk</label>
                                        <input type="text" name="item_name" id="item_name" value="{{ old('item_name') }}"
                                            class="form-control @error('item_name') is-invalid @enderror"
                                            placeholder="Masukkan nama produk">
                                        @error('item_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Deskripsi Item --}}
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="description" class="form-label fw-bold">Deskripsi Item</label>
                                        <textarea name="description" id="description" rows="3"
                                            class="form-control @error('description') is-invalid @enderror"
                                            placeholder="Masukkan deskripsi produk">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Kategori --}}
                                <div class="col-md-6 col-12">
                                    <div class="mb-2">
                                        <label for="category_id" class="form-label fw-bold">Kategori</label>
                                        <select name="category_id" id="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-Pilih kategori produk-</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->cat_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Harga --}}
                                <div class="col-md-6 col-12">
                                    <div class="mb-2">
                                        <label for="price" class="form-label fw-bold">Harga</label>
                                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                                            class="form-control @error('price') is-invalid @enderror"
                                            placeholder="Masukkan harga produk">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Gambar --}}
                                <div class="col-6">
                                    <div class="mb-2">
                                        <label for="image" class="form-label fw-bold">Gambar</label>
                                        <input type="file" name="image" id="image"
                                            class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-6">
                                    <div class="mb-2">
                                        <label for="is_active" class="form-label fw-bold">Status</label>
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_active" value="0">
                                            <input type="checkbox" name="is_active" id="flexSwitchCheckDefault"
                                                value="1"
                                                class="form-check-input @error('is_active') is-invalid @enderror"
                                                {{ old('is_active') ? 'checked' : '' }}>
                                            <label for="flexSwitchCheckDefault" class="form-check-label fw-bold">Aktif / Tidak Aktif</label>
                                            @error('is_active')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
                                <a href="{{ route('items.index') }}" class="btn btn-warning btn-sm ms-2">
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
@endsection
