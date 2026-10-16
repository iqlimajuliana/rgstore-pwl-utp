@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h1 class="h3">Dashboard Admin</h1>
        <p>Selamat datang di dashboard admin RGStore.</p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">
                Logout
            </button>
        </form>
    </div>
</div>

@endsection