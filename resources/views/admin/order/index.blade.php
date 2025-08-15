@extends('admin.layouts.master')

@section('title', 'Daftar Pesanan')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatable.css') }}">
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 order-md-1 order-last ">
                    <h3 class="text-center fw-bold">Daftar Pesanan</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    {{-- <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-subtitle text-muted">Berikut adalah daftar pesanan di restoran Anda.</h4>
                        <a href="{{ route('items.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Item
                        </a>
                    </div> --}}
                </div>
                <div class="card-body">
                    @include('admin.layouts.alert')
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pesanan</th>
                                <th>Nama Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>No Meja</th>
                                <th>Metode Pembayaran</th>
                                <td>Catatan</td>
                                <td>Dibuat Pada</td>
                                <th colspan="2" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-info"><a href="{{ route('orders.show', $item->id) }}"
                                                class="text-white">{{ $item->order_code }}</a></span>
                                    </td>
                                    <td>{{ ucfirst($item->user->fullname) }}</td>
                                    <td class="{{ $item->grand_total == 0 ? 'text-danger' : '' }}">
                                        {{ 'Rp. ' . number_format($item->grand_total, 0, ',', '.') }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $item->status == 'pending' ? 'bg-danger' : ($item->status == 'coocked' ? 'bg-primary' : 'bg-success') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $item->table_number ? $item->table_number : 'Tidak Ada' }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $item->payment_method == 'tunai' ? 'bg-warning' : ($item->payment_method == 'non_tunai' ? 'bg-success' : 'bg-danger') }}">
                                            {{ ucfirst($item->payment_method) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $item->note ? $item->note : 'Tidak Ada' }}
                                    </td>
                                    <td>
                                        {{ $item->created_at ? $item->created_at->format('d M Y H:i') : 'Tidak Ada' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">
                                            <a href="{{ route('orders.show', $item->id) }}" class="text-white">
                                                <i class="bi bi-eye"></i>
                                                Lihat
                                            </a>
                                        </span>
                                    </td>
                                    <td>
                                        {{-- update status pesanan --}}
                                        @if (Auth::user()->role->role_name == 'admin' || Auth::user()->role->role_name == 'cashier')
                                            @if ($item->status == 'pending' && $item->payment_method == 'tunai')
                                                <form action="{{ route('orders.updateStatus', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="badge bg-success">
                                                        <i class="bi bi-check-circle"></i>
                                                        Terima Pembayaran
                                                    </button>
                                                </form>
                                            @endif
                                        @elseif(Auth::user()->role->role_name == 'chef' && $item->status == 'settlement')
                                            <form action="{{ route('orders.updateStatus', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i>
                                                    Pesanan Siap
                                                </button>
                                            </form>
                                        @endif
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
