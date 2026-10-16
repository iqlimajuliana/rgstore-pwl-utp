@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <h1 class="h3 fw-bold text-center mb-2">
                    Register RGStore
                </h1>

                <p class="text-secondary text-center mb-4">
                    Buat akun baru untuk mulai menggunakan RGStore.
                </p>

                <form action="{{ route('register.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Nama
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            required>
                    </div>

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

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            minlength="8"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            minlength="8"
                            required>
                    </div>

                    <button type="submit" class="btn btn-dark w-100">
                        Daftar
                    </button>
                </form>

                <p class="text-center mt-4 mb-0">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">
                        Login
                    </a>
                </p>

            </div>
        </div>

    </div>
</div>

@endsection