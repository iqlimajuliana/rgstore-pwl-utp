@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Detail Transaksi</h2>
                <p class="text-muted mb-0">Informasi lengkap pesanan top up game Anda.</p>
            </div>
            <a href="{{ route('transactions.history') }}" class="btn btn-outline-secondary btn-sm">
                &larr; Kembali ke Riwayat
            </a>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small">No. Invoice</span>
                    <h5 class="mb-0 fw-bold text-primary">{{ $transaction->invoice_code }}</h5>
                </div>

                <div>
                    @if ($transaction->status === 'pending')
                        <span class="badge bg-warning text-dark px-3 py-2 fs-6">Menunggu Pembayaran</span>
                    @elseif ($transaction->status === 'success')
                        <span class="badge bg-success px-3 py-2 fs-6">Pesanan Selesai</span>
                    @elseif ($transaction->status === 'cancelled')
                        <span class="badge bg-danger px-3 py-2 fs-6">Pesanan Dibatalkan</span>
                    @else
                        <span class="badge bg-secondary px-3 py-2 fs-6">{{ $transaction->status }}</span>
                    @endif
                </div>
            </div>

            <div class="card-body p-4">

                @if ($transaction->status === 'pending')
                    <div class="alert alert-warning d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <strong>Perhatian!</strong> Pesanan ini belum dibayar. Segera selesaikan pembayaran agar item masuk ke akun game Anda.
                        </div>
                        <a href="{{ route('transactions.payment', $transaction->id) }}" class="btn btn-warning btn-sm fw-bold ms-3 text-nowrap">
                            Bayar Sekarang &rarr;
                        </a>
                    </div>
                @elseif ($transaction->status === 'success')
                    <div class="alert alert-success mb-4">
                        <strong>Sukses!</strong> Pembayaran Anda telah terkonfirmasi. Item game telah diproses ke ID akun yang Anda cantumkan.
                    </div>
                @elseif ($transaction->status === 'cancelled')
                    <div class="alert alert-danger mb-4">
                        Pesanan ini telah dibatalkan. Jika Anda ingin melakukan pemesanan ulang, silakan buat transaksi baru.
                    </div>
                @endif

                <h6 class="fw-bold text-secondary mb-3">Informasi Akun Game & Pemesan</h6>
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded">
                            <span class="text-muted small d-block">Nama Game</span>
                            <span class="fw-bold">{{ $transaction->game ? $transaction->game->name : 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded">
                            <span class="text-muted small d-block">User / Player ID</span>
                            <span class="fw-bold">{{ $transaction->user_game_id }}</span>
                            @if ($transaction->zone_id)
                                <span class="text-muted">(Server: {{ $transaction->zone_id }})</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded">
                            <span class="text-muted small d-block">Nominal Paket</span>
                            <span class="fw-bold text-primary">{{ $transaction->amount }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded">
                            <span class="text-muted small d-block">Metode Pembayaran</span>
                            <span class="fw-bold">{{ $transaction->payment_method }}</span>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold text-secondary mb-3">Rincian Pembayaran</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Deskripsi</th>
                                <th class="text-end" style="width: 200px;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Top Up {{ $transaction->game ? $transaction->game->name : '' }} - {{ $transaction->amount }}
                                </td>
                                <td class="text-end">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Biaya Admin / Layanan</td>
                                <td class="text-end text-success">Rp 0 (Gratis)</td>
                            </tr>
                            <tr class="table-light">
                                <td class="fw-bold fs-6">Total Pembayaran</td>
                                <td class="fw-bold fs-6 text-end text-danger">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-muted small mb-4">
                    <div>Waktu Transaksi Dibuat: {{ $transaction->created_at->format('d F Y, H:i:s') }} WIB</div>
                    <div>Terakhir Diperbarui: {{ $transaction->updated_at->format('d F Y, H:i:s') }} WIB</div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('games.catalog') }}" class="btn btn-outline-secondary">
                        Katalog Game
                    </a>

                    @if ($transaction->status === 'pending')
                        <div class="d-flex gap-2">
                            <form action="{{ route('transactions.cancel', $transaction->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?');">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    Batalkan
                                </button>
                            </form>
                            <a href="{{ route('transactions.payment', $transaction->id) }}" class="btn btn-primary">
                                Bayar Sekarang
                            </a>
                        </div>
                    @else
                        <a href="{{ route('transactions.checkout') }}" class="btn btn-primary">
                            + Top Up Lagi
                        </a>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
