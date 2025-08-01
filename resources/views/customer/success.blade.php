@extends('customer.layouts.master')

@section('content')
    <div class="container-fluid py-5 d-flex justify-content-center align-items-center">
        <div class="receipt border p-4 bg-white shadow" style="width: 450px; margin-top: 5rem;">
            <h5 class="text-center mb-2">
                <i class="fa fa-check-circle text-success"></i> Pesanan Berhasil Dibuat
            </h5>
            @if ($order->payment_method == 'tunai' && $order->status == 'pending')
                <p class="text-center mb-4"><span class="badge bg-danger">menunggu pembayaran</span></p>
            @elseif ($order->payment_method == 'non_tunai' && $order->status == 'pending')
                <p class="text-center mb-4"><span class="badge bg-warning">menunggu konfirmasi pembayaran</span></p>
            @else
                <p class="text-center mb-4"><span class="badge bg-success">Pembayaran berhasil, pesanan segera diproses</span></p>
            @endif
            <hr>

            <h4 class="fw-bold text-center">
                Kode Bayar : <br> <span class="text-primary">{{$order->order_code}}</span>
            </h4>
            <h5 class="mb-3 text-center">
                Detail pesanan :
            </h5>
            <table class="table table-borderless">
                <tbody>
                    @foreach ($orderItems as $item)
                        <tr>
                            <td>{{ Str::limit($item->item->item_name, 25) }}({{$item->quantity}})</td>
                            <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="fw-bold">Subtotal</td>
                        <td class="text-end">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Pajak (10%)</td>
                        <td class="text-end">Rp {{ number_format($order->tax, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td>Total</td>
                        <td class="text-end">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            @if ($order->payment_method == 'tunai')
                <p class="small text-center fw-bold">Tunjukan kode bayar ini ke kasir untuk menyelesaikan pembayaran 🤗</p>
            @elseif ($order->payment_method == 'non_tunai')
                <p class="small text-center fw-bold"> Yeay! Pembayaran sukses. Pesanan kamu sedang diproses 🤩 </p>
            @endif
            <hr>
            <a href="{{route('menu')}}" class="btn btn-primary w-100">Kembali ke menu</a>
        </div>
    </div>
@endsection