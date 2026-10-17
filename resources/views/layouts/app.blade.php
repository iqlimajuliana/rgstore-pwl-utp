<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'RGStore' }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')) : '/' }}">
                RGStore
            </a>

            @auth
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('games.catalog') }}" class="btn btn-outline-light btn-sm">
                        Katalog
                    </a>
                    <a href="{{ route('transactions.checkout') }}" class="btn btn-primary btn-sm">
                        Top Up
                    </a>
                    <a href="{{ route('transactions.history') }}" class="btn btn-outline-info btn-sm">
                        Riwayat
                    </a>

                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.games.index') }}" class="btn btn-warning btn-sm">
                            Admin Game
                        </a>
                        <a href="{{ route('admin.packages.index') }}" class="btn btn-warning btn-sm">
                            Admin Paket
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            Logout ({{ Auth::user()->name }})
                        </button>
                    </form>
                </div>
            @else
                <span class="text-white">
                    Game Top Up Store
                </span>
            @endauth
        </div>
    </nav>

    <main class="container py-5">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
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

        @yield('content')

    </main>

</body>
</html>