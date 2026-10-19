@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Semua Pengaduan</h1>
        <p class="text-muted mb-0">Tinjau dan teruskan penanganan pengaduan pengguna.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
</div>

<div class="card border-0 shadow-sm">
    @if ($complaints->isEmpty())
        <div class="card-body text-center text-muted py-5">Belum ada pengaduan yang masuk.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Pengguna</th><th>Subjek</th><th>Transaksi</th><th>Status</th><th>Dikirim</th><th></th></tr></thead>
                <tbody>
                    @foreach ($complaints as $complaint)
                        <tr>
                            <td>{{ $complaint->user->name }}<small class="d-block text-muted">{{ $complaint->user->email }}</small></td>
                            <td class="fw-semibold">{{ $complaint->subject }}</td>
                            <td>{{ $complaint->transaction?->invoice_code ?? '-' }}</td>
                            <td><span class="badge text-bg-secondary">{{ str_replace('_', ' ', ucfirst($complaint->status)) }}</span></td>
                            <td>{{ $complaint->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end"><a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-sm btn-outline-primary">Tangani</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
<div class="mt-3">{{ $complaints->links() }}</div>
@endsection