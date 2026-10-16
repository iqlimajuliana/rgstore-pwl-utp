@extends('layouts.app')

@section('content')
<div class="container">

    <div class="mb-4">
        <h2>Tambah Game</h2>
        <p>Tambahkan game baru ke katalog RGStore.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum dapat disimpan.</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.games.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">
                        Nama Game
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Mobile Legends"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="4"
                        placeholder="Masukkan deskripsi game"
                    >{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="currency" class="form-label">
                        Currency / Satuan Top Up
                    </label>

                    <input
                        type="text"
                        name="currency"
                        id="currency"
                        class="form-control"
                        value="{{ old('currency') }}"
                        placeholder="Contoh: Diamonds"
                        required
                    >
                </div>

                <div class="form-check mb-4">
                    <input
                        type="checkbox"
                        name="is_active"
                        id="is_active"
                        class="form-check-input"
                        value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                    >

                    <label for="is_active" class="form-check-label">
                        Game Aktif
                    </label>
                </div>

                <a
                    href="{{ route('admin.games.index') }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Game
                </button>

            </form>

        </div>
    </div>

</div>
@endsection