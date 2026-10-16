@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Paket Top Up</h2>
            <p>Kelola paket top up yang tersedia untuk setiap game.</p>
        </div>

        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
            + Tambah Paket
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($packages->count() > 0)

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Game</th>
                        <th>Nominal</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $package->game->name }}
                            </td>

                            <td>
                                {{ $package->amount }}
                            </td>

                            <td>
                                Rp {{ number_format($package->price, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($package->is_active)
                                    <span class="badge bg-success">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a
                                    href="{{ route('admin.packages.show', $package) }}"
                                    class="btn btn-info btn-sm"
                                >
                                    Detail
                                </a>

                                <a
                                    href="{{ route('admin.packages.edit', $package) }}"
                                    class="btn btn-warning btn-sm"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.packages.destroy', $package) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus paket ini?')"
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
            Belum ada paket top up.
        </div>

    @endif

</div>
@endsection