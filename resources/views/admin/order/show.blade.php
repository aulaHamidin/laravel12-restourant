@extends('admin.layouts.master')

@section('title', 'Detail Pesanan')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatable.css') }}">
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 order-md-1 order-last ">
                    <h3 class="text-center fw-bold">Detail Pesanan</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4>Kode Pesanan : <span class="badge bg-info">{{ $order->order_code }}</span></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama Pelanggan :</strong> {{ $order->user->fullname }}</p>
                            <p><strong>Status :</strong>
                                <span
                                    class="badge {{ $order->status == 'pending' ? 'bg-danger' : ($order->status == 'coocked' ? 'bg-primary' : 'bg-success') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p><strong>Metode Pembayaran :</strong>
                                <span
                                    class="badge {{ $order->payment_method == 'tunai' ? 'bg-warning' : ($order->payment_method == 'non_tunai' ? 'bg-success' : 'bg-danger') }}">
                                    {{ ucfirst($order->payment_method) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal Buat :</strong>
                                {{ $order->created_at ? $order->created_at->format('d M Y H:i') : 'Tidak Ada' }}
                            </p>
                            <p>
                                <strong>No Meja :</strong> {{ $order->table_number ? $order->table_number : 'Tidak Ada' }}
                            </p>
                            <p class="text-muted"><strong class="text-primary">Catatan :</strong> {{ $order->note ? $order->note : 'Tidak Ada' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Item Pesanan</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Menu</th>
                                <th>Jumlah</th>
                                <td>Harga</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset('assets/img_item/' . $item->item->image) }}"
                                            alt="{{ $item->item->item_name }}" class="img-fluid rounded w-full"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ ucfirst($item->item->item_name) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ 'Rp. ' . number_format($item->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tr>
                            <td class="text-end fw-bold" colspan="4">Total</td>
                            <td>{{ 'Rp. ' . number_format($order->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-end fw-bold" colspan="4">Pajak</td>
                            <td>{{ 'Rp. ' . number_format($order->tax, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-end fw-bold" colspan="4">Diskon</td>
                            <td>{{ 'Rp. ' . number_format($order->discount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-end fw-bold" colspan="4">Grand Total</td>
                            <td>{{ 'Rp. ' . number_format($order->grand_total, 0, ',', '.') }}</td>
                        </tr>

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
