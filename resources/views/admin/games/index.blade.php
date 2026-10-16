@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Manajemen Game</h2>
            <p>Kelola game yang tersedia di RGStore.</p>
        </div>

        <a href="{{ route('admin.games.create') }}" class="btn btn-primary">
            + Tambah Game
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($games->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Game</th>
                        <th>Deskripsi</th>
                        <th>Currency</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($games as $game)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $game->name }}
                            </td>

                            <td>
                                {{ $game->description ?: '-' }}
                            </td>

                            <td>
                                {{ $game->currency }}
                            </td>

                            <td>
                                @if ($game->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>

                            <td>
                                <a
                                    href="{{ route('admin.games.show', $game) }}"
                                    class="btn btn-info btn-sm"
                                >
                                    Detail
                                </a>

                                <a
                                    href="{{ route('admin.games.edit', $game) }}"
                                    class="btn btn-warning btn-sm"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.games.destroy', $game) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus game ini?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            Belum ada game yang tersedia.
        </div>
    @endif

</div>
@endsection