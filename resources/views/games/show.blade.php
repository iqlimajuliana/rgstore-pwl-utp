@extends('layouts.app')

@section('content')
<div class="container">

    <div class="mb-4">
        <h2>{{ $game->name }}</h2>

        @if ($game->description)
            <p>{{ $game->description }}</p>
        @endif
    </div>

    <div class="card">
        <div class="card-body">

            <h4>Paket Top Up</h4>

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

            <a
                href="{{ route('games.catalog') }}"
                class="btn btn-secondary"
            >
                Kembali ke Katalog
            </a>

        </div>
    </div>

</div>
@endsection