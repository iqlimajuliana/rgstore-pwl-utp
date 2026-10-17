@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h1 class="h3">Dashboard User</h1>
        <p>Selamat datang di <strong>RGStore</strong> - Layanan Top Up Game Cepat & Terpercaya.</p>

        <div class="row g-3 my-3">
            <div class="col-md-4">
                <div class="card h-100 border bg-white">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Katalog Game</h5>
                        <p class="card-text text-muted small">Lihat daftar game dan paket nominal yang tersedia.</p>
                        <a href="{{ route('games.catalog') }}" class="btn btn-outline-primary btn-sm">Buka Katalog</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border bg-white">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Top Up Sekarang</h5>
                        <p class="card-text text-muted small">Pilih paket, isi ID akun, dan bayar pesananmu.</p>
                        <a href="{{ route('transactions.checkout') }}" class="btn btn-primary btn-sm">Mulai Top Up</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border bg-white">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Riwayat Transaksi</h5>
                        <p class="card-text text-muted small">Pantau status pesanan dan pembayaran kamu.</p>
                        <a href="{{ route('transactions.history') }}" class="btn btn-outline-secondary btn-sm">Lihat Riwayat</a>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-danger">
                Logout
            </button>
        </form>
    </div>
</div>

@endsection