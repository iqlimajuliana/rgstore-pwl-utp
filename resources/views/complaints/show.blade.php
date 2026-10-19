@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Detail Pengaduan</h1>
                <p class="text-muted mb-0">Dikirim {{ $complaint->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <a href="{{ route('complaints.index') }}" class="btn btn-outline-secondary">Daftar Pengaduan</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h2 class="h5 fw-bold mb-0">{{ $complaint->subject }}</h2>
                <span class="badge text-bg-secondary">{{ str_replace('_', ' ', ucfirst($complaint->status)) }}</span>
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-1">Transaksi terkait</p>
                <p>{{ $complaint->transaction?->invoice_code ?? 'Tidak ada' }}</p>
                <p class="text-muted small mb-1">Detail</p>
                <p class="mb-4" style="white-space: pre-line">{{ $complaint->message }}</p>
                <div class="d-flex justify-content-between border-top pt-3">
                    <form action="{{ route('complaints.destroy', $complaint) }}" method="POST" onsubmit="return confirm('Hapus pengaduan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">Hapus</button>
                    </form>
                    <a href="{{ route('complaints.edit', $complaint) }}" class="btn btn-primary">Edit Pengaduan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection