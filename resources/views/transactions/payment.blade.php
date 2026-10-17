@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-warning bg-opacity-25 py-3 text-center">
                <span class="badge bg-warning text-dark mb-2">Menunggu Pembayaran</span>
                <h3 class="fw-bold mb-1">Instruksi Pembayaran</h3>
                <p class="text-muted mb-0">Selesaikan pembayaran untuk memproses pesanan top up kamu.</p>
            </div>

            <div class="card-body p-4">
                {{-- Detail Invoice --}}
                <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                    <div>
                        <span class="text-muted small">No. Invoice</span>
                        <div class="fw-bold fs-5 text-primary">{{ $transaction->invoice_code }}</div>
                    </div>
                    <div class="text-end">
                        <span class="text-muted small">Waktu Pemesanan</span>
                        <div class="fw-medium">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</div>
                    </div>
                </div>

                {{-- Rincian Pesanan --}}
                <h6 class="fw-bold text-secondary mb-3">Rincian Pesanan:</h6>
                <table class="table table-borderless table-sm mb-4">
                    <tbody>
                        <tr>
                            <td class="text-muted">Game</td>
                            <td class="fw-semibold text-end">{{ $transaction->game->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Paket Nominal</td>
                            <td class="fw-semibold text-end">{{ $transaction->amount }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">ID Akun Player</td>
                            <td class="fw-semibold text-end">
                                {{ $transaction->user_game_id }}
                                @if($transaction->zone_id)
                                    ({{ $transaction->zone_id }})
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Metode Pembayaran</td>
                            <td class="fw-semibold text-end">{{ $transaction->payment_method }}</td>
                        </tr>
                        <tr class="border-top">
                            <td class="fs-5 fw-bold text-dark pt-2">Total Pembayaran</td>
                            <td class="fs-5 fw-bold text-danger text-end pt-2">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- Panduan Transfer --}}
                <div class="alert alert-light border p-3 mb-4">
                    <h6 class="fw-bold mb-2">Panduan Pembayaran ({{ $transaction->payment_method }}):</h6>
                    @if (in_array($transaction->payment_method, ['BCA', 'Mandiri', 'BRI']))
                        <p class="mb-1 small">Silakan transfer tepat sesuai nominal ke nomor rekening resmi RGStore berikut:</p>
                        <div class="bg-white p-2 border rounded fw-bold text-center my-2 fs-5 text-dark">
                            123-456-7890 <span class="text-muted fs-6 fw-normal">(a.n RGStore Official)</span>
                        </div>
                        <p class="mb-0 small text-muted">Gunakan nomor invoice sebagai berita transfer jika diperlukan.</p>
                    @elseif ($transaction->payment_method === 'QRIS')
                        <div class="text-center my-3">
                            <div class="p-3 bg-white border d-inline-block rounded shadow-sm">
                                <div class="bg-dark text-white p-4 rounded text-center" style="letter-spacing: 2px;">
                                    [ SIMULASI KODE QRIS ]<br>
                                    <small class="text-warning">Scan dengan E-Wallet / Mobile Banking</small>
                                </div>
                            </div>
                        </div>
                        <p class="small text-center text-muted mb-0">Buka aplikasi E-Wallet atau m-Banking Anda, pilih menu Scan QRIS, dan bayar sebesar <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>.</p>
                    @else
                        <p class="mb-1 small">Silakan kirim saldo ke nomor akun e-wallet resmi RGStore:</p>
                        <div class="bg-white p-2 border rounded fw-bold text-center my-2 fs-5 text-dark">
                            0812-3456-7890 <span class="text-muted fs-6 fw-normal">(a.n RGStore Official)</span>
                        </div>
                        <p class="mb-0 small text-muted">Pastikan nama penerima bertuliskan RGStore Official sebelum menyelesaikan transfer.</p>
                    @endif
                </div>

                {{-- Tombol Aksi --}}
                @if ($transaction->status === 'pending')
                    <div class="d-grid gap-2 mb-3">
                        <form action="{{ route('transactions.pay', $transaction->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">
                                Saya Sudah Bayar
                            </button>
                        </form>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('transactions.history') }}" class="btn btn-outline-secondary">
                            Bayar Nanti (Lihat Riwayat)
                        </a>

                        <form action="{{ route('transactions.cancel', $transaction->id) }}" method="POST"
                            onsubmit="return confirm('Apakah kamu yakin ingin membatalkan pesanan ini?');">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                @else
                    <div class="d-grid">
                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-primary">
                            Lihat Detail Pesanan
                        </a>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
