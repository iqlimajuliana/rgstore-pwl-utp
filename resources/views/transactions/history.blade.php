@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Riwayat Transaksi</h2>
            <p class="text-muted mb-0">Daftar seluruh transaksi pembelian top up game kamu.</p>
        </div>

        <div>
            <a href="{{ route('transactions.checkout') }}" class="btn btn-primary">
                + Top Up Baru
            </a>
            <a href="{{ route('games.catalog') }}" class="btn btn-outline-secondary">
                Katalog Game
            </a>
        </div>
    </div>

    @if ($transactions->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>No. Invoice</th>
                            <th>Game</th>
                            <th>Nominal</th>
                            <th>ID Player</th>
                            <th>Total Bayar</th>
                            <th>Metode</th>
                            <th>Tanggal</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-semibold text-primary">
                                        {{ $transaction->invoice_code }}
                                    </span>
                                </td>
                                <td class="fw-medium">
                                    {{ $transaction->game ? $transaction->game->name : 'Game Dihapus' }}
                                </td>
                                <td>{{ $transaction->amount }}</td>
                                <td>
                                    <code>{{ $transaction->user_game_id }}</code>
                                    @if ($transaction->zone_id)
                                        <small class="text-muted">({{ $transaction->zone_id }})</small>
                                    @endif
                                </td>
                                <td class="fw-bold text-danger">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $transaction->payment_method }}
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    @if ($transaction->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($transaction->status === 'success')
                                        <span class="badge bg-success">Berhasil</span>
                                    @elseif ($transaction->status === 'cancelled')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $transaction->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-outline-info">
                                            Detail
                                        </a>

                                        @if ($transaction->status === 'pending')
                                            <a href="{{ route('transactions.payment', $transaction->id) }}" class="btn btn-warning text-dark">
                                                Bayar
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <div class="display-6 text-muted mb-3">&#128722;</div>
                <h5 class="fw-bold">Belum Ada Transaksi</h5>
                <p class="text-muted mb-4">Kamu belum pernah melakukan transaksi top up game di RGStore.</p>
                <a href="{{ route('transactions.checkout') }}" class="btn btn-primary px-4">
                    Mulai Top Up Sekarang
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
