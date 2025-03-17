@extends('layouts.auth')
@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                        <div class="card-body">
                       ONLY ADMIN PRIVILEGES CAN ACCESS THIS PAGE!
                        </div>
                    </div>
                </div>
            </div>
</div>
<div class="container">
    <h2>Riwayat Transaksi</h2>

    {{-- Debugging: Cek apakah data order dikirim --}}
    <pre>{{ print_r($orders, true) }}</pre>

    <table class="table">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama Pengguna</th>
                <th>Tanggal</th>
                <th>Alamat</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->date }}</td>
                <td>{{ $order->deliveryAddress }}</td>
                <td><a href="#">Lihat Detail</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection