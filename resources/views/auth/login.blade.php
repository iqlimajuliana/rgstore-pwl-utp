@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <h1 class="h3 fw-bold text-center mb-2">
                    Login RGStore
                </h1>

                <p class="text-secondary text-center mb-4">
                    Masuk ke akunmu untuk melanjutkan.
                </p>

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            required>
                    </div>

                    <button type="submit" class="btn btn-dark w-100">
                        Login
                    </button>
                </form>

                <p class="text-center mt-4 mb-0">
                    Belum punya akun?
                    <a href="{{ route('register') }}">
                        Daftar sekarang
                    </a>
                </p>

            </div>
        </div>

    </div>
</div>

@endsection