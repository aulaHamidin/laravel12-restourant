@extends('admin.layouts.master')

@section('title', 'Daftar Item')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatable.css') }}">
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Menu</h3>
                    <p class="text-subtitle text-muted">Berikut adalah daftar menu yang tersedia di restoran Anda.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <a href="{{route('items.create')}}" class="btn btn-primary float-start float-lg-end">
                        <i class="bi bi-plus"></i> Tambah Item
                    </a>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Item</th>
                                <th>Deskripsi</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{asset('img_item'. $item->image)}}" alt="{{ $item->item_name }}"
                                            class="img-fluid rounded w-full" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ Str::limit($item->description, 15) }}</td>
                                    <td>
                                        <i class="bi bi-tags"></i>
                                        @php
                                            $catName = ucfirst($item->category->cat_name);
                                            $badgeClass = $item->category->cat_name == 'makanan' ? 'bg-secondary' : ($item->category->cat_name == 'minuman' ? 'bg-primary' : 'bg-warning');
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $catName }}</span>
                                    </td>
                                    <td>{{ 'Rp. ' . number_format($item->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $item->is_active == 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}   
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/admin/static/js/pages/simple-datatables.js') }}"></script>
@endsection
