@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Pengaduan Saya</h1>
        <p class="text-muted mb-0">Pantau dan kelola pengaduan yang Anda kirim.</p>
    </div>
    <a href="{{ route('complaints.create') }}" class="btn btn-primary">Buat Pengaduan</a>
</div>

@if ($complaints->isEmpty())
    <div class="card border-0 shadow-sm text-center py-5">
        <div class="card-body">
            <h2 class="h5 fw-bold">Belum ada pengaduan</h2>
            <p class="text-muted">Pengaduan yang Anda kirim akan muncul di halaman ini.</p>
            <a href="{{ route('complaints.create') }}" class="btn btn-primary">Buat Pengaduan</a>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Subjek</th>
                        <th>Transaksi</th>
                        <th>Status</th>
                        <th>Dikirim</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($complaints as $complaint)
                        <tr>
                            <td class="fw-semibold">{{ $complaint->subject }}</td>
                            <td>{{ $complaint->transaction?->invoice_code ?? '-' }}</td>
                            <td><span class="badge text-bg-secondary">{{ str_replace('_', ' ', ucfirst($complaint->status)) }}</span></td>
                            <td>{{ $complaint->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('complaints.show', $complaint) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                <a href="{{ route('complaints.edit', $complaint) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $complaints->links() }}</div>
@endif
@endsection