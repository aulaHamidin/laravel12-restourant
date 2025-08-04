@extends('admin.layouts.master')

@section('title', 'Daftar Role')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatable.css') }}">
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 order-md-1 order-last ">
                    <h3 class="text-center fw-bold">Daftar Role</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-subtitle text-muted">Berikut adalah daftar role yang tersedia di restoran Anda.
                        </h4>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Role
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @include('admin.layouts.alert')
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Role</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucfirst($item->role_name) }}</td>
                                    <td class="{{$item->description == 'Tidak ada deskripsi' ? 'text-danger' : ''}}">{{ Str::limit($item->description, 25) }}</td>
                                    <td>
                                        <a href="{{ route('roles.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('roles.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
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
