@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Form Top Up Game</h2>
                <p class="text-muted mb-0">Isi data akun dan pilih paket top up yang kamu inginkan.</p>
            </div>
            <div>
                <a href="{{ route('transactions.history') }}" class="btn btn-outline-primary btn-sm me-1">
                    Riwayat Transaksi
                </a>
                <a href="{{ route('games.catalog') }}" class="btn btn-outline-secondary btn-sm">
                    Katalog Game
                </a>
            </div>
        </div>

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            {{-- 1. Pilih Game & Paket --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold text-primary">1. Pilih Game & Nominal Top Up</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label for="game_id" class="form-label fw-semibold">Pilih Game <span class="text-danger">*</span></label>
                        <select name="game_id" id="game_id" class="form-select @error('game_id') is-invalid @enderror" required onchange="filterPackages()">
                            <option value="">-- Pilih Game --</option>
                            @foreach ($games as $game)
                                <option value="{{ $game->id }}"
                                    data-currency="{{ $game->currency }}"
                                    {{ old('game_id', $selectedGameId) == $game->id ? 'selected' : '' }}>
                                    {{ $game->name }} (Mata Uang: {{ $game->currency }})
                                </option>
                            @endforeach
                        </select>
                        @error('game_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="package_id" class="form-label fw-semibold">Pilih Paket Nominal <span class="text-danger">*</span></label>
                        <select name="package_id" id="package_id" class="form-select @error('package_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Nominal Top Up --</option>
                            @foreach ($games as $game)
                                @foreach ($game->topupPackages as $package)
                                    <option value="{{ $package->id }}"
                                        data-game="{{ $game->id }}"
                                        {{ old('package_id', $selectedPackageId) == $package->id ? 'selected' : '' }}>
                                        {{ $game->name }} - {{ $package->amount }} &bull; Rp {{ number_format($package->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('package_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Pilih game terlebih dahulu untuk melihat daftar paket yang tersedia.</div>
                    </div>
                </div>
            </div>

            {{-- 2. Data Akun Game --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold text-primary">2. Masukkan Data Akun Game</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <label for="user_game_id" class="form-label fw-semibold">User ID / Player ID <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('user_game_id') is-invalid @enderror"
                                id="user_game_id"
                                name="user_game_id"
                                value="{{ old('user_game_id') }}"
                                placeholder="Contoh: 123456789"
                                required>
                            @error('user_game_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-5 mb-3">
                            <label for="zone_id" class="form-label fw-semibold">Zone ID / Server ID <span class="text-muted">(Opsional)</span></label>
                            <input type="text"
                                class="form-control @error('zone_id') is-invalid @enderror"
                                id="zone_id"
                                name="zone_id"
                                value="{{ old('zone_id') }}"
                                placeholder="Contoh: 2023">
                            @error('zone_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-text">Pastikan ID Game dan Server sudah benar agar pengiriman diamond/koin tidak salah akun.</div>
                </div>
            </div>

            {{-- 3. Metode Pembayaran --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold text-primary">3. Pilih Metode Pembayaran</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach ($paymentMethods as $key => $label)
                            <div class="col-md-6">
                                <div class="form-check p-3 border rounded h-100">
                                    <input class="form-check-input ms-0 me-2"
                                        type="radio"
                                        name="payment_method"
                                        id="payment_{{ $key }}"
                                        value="{{ $key }}"
                                        {{ (old('payment_method') == $key || $loop->first) ? 'checked' : '' }}
                                        required>
                                    <label class="form-check-label fw-medium w-100 cursor-pointer" for="payment_{{ $key }}">
                                        {{ $label }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('payment_method')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid gap-2 mb-5">
                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                    Konfirmasi & Buat Pesanan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
function filterPackages() {
    const gameSelect = document.getElementById('game_id');
    const selectedGameId = gameSelect.value;
    const packageSelect = document.getElementById('package_id');
    const options = packageSelect.querySelectorAll('option[data-game]');

    let hasVisibleSelected = false;

    options.forEach(opt => {
        if (!selectedGameId || opt.getAttribute('data-game') === selectedGameId) {
            opt.style.display = '';
            opt.disabled = false;
            if (opt.selected) {
                hasVisibleSelected = true;
            }
        } else {
            opt.style.display = 'none';
            opt.disabled = true;
            if (opt.selected) {
                opt.selected = false;
            }
        }
    });

    if (!hasVisibleSelected && selectedGameId) {
        // jika paket yang terpilih sebelumnya tidak cocok dengan game baru, reset ke opsi pertama
        for (let i = 0; i < options.length; i++) {
            if (options[i].getAttribute('data-game') === selectedGameId) {
                options[i].selected = true;
                break;
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    filterPackages();
});
</script>
@endsection
