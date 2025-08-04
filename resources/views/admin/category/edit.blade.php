@extends('admin.layouts.master')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Kategori</h3>
                    <p class="text-subtitle text-muted">Silahkan Isi Data Kategori Yang Ingin Diubah</p>
                </div>
            </div>
        </div>
        <div class="page-content">
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row">

                                {{-- Nama Kategori --}}
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="cat_name" class="form-label fw-bold">Nama Produk</label>
                                        <input type="text" name="cat_name" id="cat_name" value="{{ old('cat_name', $category->cat_name) }}"
                                            class="form-control @error('cat_name') is-invalid @enderror"
                                            placeholder="Masukkan nama kategori">
                                        @error('cat_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Deskripsi Kategori --}}
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="description" class="form-label fw-bold">Deskripsi</label>
                                        <textarea name="description" id="description" rows="3"
                                            class="form-control @error('description') is-invalid @enderror"
                                            placeholder="Masukkan deskripsi kategori">{{ old('description', $category->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                    <a href="{{ route('categories.index') }}" class="btn btn-warning btn-sm ms-2">
                                        <i class="bi bi-arrow-left"></i>
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
