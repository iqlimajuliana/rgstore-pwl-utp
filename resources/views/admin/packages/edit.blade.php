@extends('layouts.app')

@section('content')
<div class="container">

    <div class="mb-4">
        <h2>Edit Paket Top Up</h2>
        <p>Ubah informasi paket top up.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum dapat diperbarui.</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <form
                action="{{ route('admin.packages.update', $package) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="game_id" class="form-label">
                        Game
                    </label>

                    <select
                        name="game_id"
                        id="game_id"
                        class="form-control"
                        required
                    >
                        <option value="">
                            -- Pilih Game --
                        </option>

                        @foreach ($games as $game)
                            <option
                                value="{{ $game->id }}"
                                {{ old('game_id', $package->game_id) == $game->id ? 'selected' : '' }}
                            >
                                {{ $game->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">
                        Nominal Top Up
                    </label>

                    <input
                        type="text"
                        name="amount"
                        id="amount"
                        class="form-control"
                        value="{{ old('amount', $package->amount) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">
                        Harga
                    </label>

                    <input
                        type="number"
                        name="price"
                        id="price"
                        class="form-control"
                        value="{{ old('price', $package->price) }}"
                        min="0"
                        required
                    >
                </div>

                <div class="form-check mb-4">
                    <input
                        type="checkbox"
                        name="is_active"
                        id="is_active"
                        value="1"
                        class="form-check-input"
                        {{ old('is_active', $package->is_active) ? 'checked' : '' }}
                    >

                    <label for="is_active" class="form-check-label">
                        Paket Aktif
                    </label>
                </div>

                <a
                    href="{{ route('admin.packages.index') }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

            </form>

        </div>
    </div>

</div>
@endsection