@extends('layouts.app')

@section('content')
<div class="container">

    <div class="mb-4">
        <h2>Katalog Game</h2>
        <p>Pilih game dan lihat paket top up yang tersedia.</p>
    </div>

    @if ($games->count() > 0)

        @foreach ($games as $game)

            <div class="card mb-4">
                <div class="card-body">

                    <h4>{{ $game->name }}</h4>

                    @if ($game->description)
                        <p>{{ $game->description }}</p>
                    @endif

                    <hr>

                    <h5>Paket Top Up</h5>

                    @if ($game->topupPackages->where('is_active', true)->count() > 0)

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nominal</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($game->topupPackages->where('is_active', true) as $package)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $package->amount }}</td>
                                            <td>
                                                Rp {{ number_format($package->price, 0, ',', '.') }}
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