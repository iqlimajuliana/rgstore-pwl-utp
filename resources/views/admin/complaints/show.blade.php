@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Penanganan Pengaduan</h1>
                <p class="text-muted mb-0">Dikirim {{ $complaint->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary">Daftar Pengaduan</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h2 class="h5 fw-bold mb-1">{{ $complaint->subject }}</h2>
                <span class="text-muted">{{ $complaint->user->name }} ({{ $complaint->user->email }})</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-6"><div class="text-muted small">Transaksi</div><div>{{ $complaint->transaction?->invoice_code ?? 'Tidak terkait transaksi' }}</div></div>
                    <div class="col-md-6"><div class="text-muted small">Status saat ini</div><div class="fw-semibold">{{ str_replace('_', ' ', ucfirst($complaint->status)) }}</div></div>
                </div>
                <div class="text-muted small">Detail pengaduan</div>
                <p class="mt-1 mb-4" style="white-space: pre-line">{{ $complaint->message }}</p>
                <form action="{{ route('admin.complaints.status', $complaint) }}" method="POST" class="border-top pt-4">
                    @csrf
                    @method('PATCH')
                    <label for="status" class="form-label fw-semibold">Ubah status</label>
                    <div class="d-flex flex-wrap gap-2">
                        <select name="status" id="status" class="form-select" style="max-width: 240px" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(old('status', $complaint->status) === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Simpan Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection