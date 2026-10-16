@extends('layouts.app')

@section('content')
<div class="container">

    <div class="mb-4">
        <h2>Detail Paket Top Up</h2>
        <p>Informasi paket top up.</p>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="mb-3">
                <strong>Game</strong>
                <p>{{ $package->game->name }}</p>
            </div>

            <div class="mb-3">
                <strong>Nominal</strong>
                <p>{{ $package->amount }}</p>
            </div>

            <div class="mb-3">
                <strong>Harga</strong>
                <p>
                    Rp {{ number_format($package->price, 0, ',', '.') }}
                </p>
            </div>

            <div class="mb-4">
                <strong>Status</strong>
                <p>
                    @if ($package->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Tidak Aktif</span>
                    @endif
                </p>
            </div>

            <a
                href="{{ route('admin.packages.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

            <a
                href="{{ route('admin.packages.edit', $package) }}"
                class="btn btn-warning"
            >
                Edit
            </a>

        </div>
    </div>

</div>
@endsection