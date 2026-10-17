@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Katalog Game</h2>
            <p class="mb-0">Pilih game dan lihat paket top up yang tersedia.</p>
        </div>
        <div>
            <a href="{{ route('transactions.history') }}" class="btn btn-outline-primary btn-sm me-1">
                Riwayat Transaksi
            </a>
            <a href="{{ route('transactions.checkout') }}" class="btn btn-primary btn-sm">
                + Form Top Up
            </a>
        </div>
    </div>

    @if ($games->count() > 0)

        @foreach ($games as $game)

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">

                    <h4>{{ $game->name }}</h4>

                    @if ($game->description)
                        <p class="text-muted">{{ $game->description }}</p>
                    @endif

                    <hr>

                    <h5>Paket Top Up</h5>

                    @if ($game->topupPackages->where('is_active', true)->count() > 0)

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Nominal</th>
                                        <th>Harga</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($game->topupPackages->where('is_active', true) as $package)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-medium">{{ $package->amount }}</td>
                                            <td class="fw-bold text-danger">
                                                Rp {{ number_format($package->price, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('transactions.checkout', ['game_id' => $game->id, 'package_id' => $package->id]) }}" class="btn btn-primary btn-sm">
                                                    Beli Sekarang
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else

                        <p class="text-muted">
                            Belum ada paket top up yang tersedia.
                        </p>

                    @endif

                </div>
            </div>

        @endforeach

    @else

        <div class="alert alert-info">
            Belum ada game yang tersedia.
        </div>

    @endif

</div>
@endsection