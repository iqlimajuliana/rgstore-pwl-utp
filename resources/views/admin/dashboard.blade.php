@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h1 class="h3 fw-bold mb-1">Dashboard Admin</h1>
    <p class="text-muted mb-0">Ringkasan transaksi dan pengaduan RGStore.</p>
</div>

<h2 class="h5 fw-bold mb-3">Transaksi</h2>
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Total</div><div class="h3 mb-0">{{ $transactionSummary['total'] }}</div></div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Menunggu pembayaran</div><div class="h3 mb-0 text-warning-emphasis">{{ $transactionSummary['pending'] }}</div></div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Berhasil</div><div class="h3 mb-0 text-success">{{ $transactionSummary['success'] }}</div></div></div></div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h5 fw-bold mb-0">Pengaduan</h2>
    <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-primary btn-sm">Kelola Pengaduan</a>
</div>
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Total</div><div class="h3 mb-0">{{ $complaintSummary['total'] }}</div></div></div></div>
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Baru</div><div class="h3 mb-0 text-primary">{{ $complaintSummary['open'] }}</div></div></div></div>
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Diproses</div><div class="h3 mb-0 text-warning-emphasis">{{ $complaintSummary['inProgress'] }}</div></div></div></div>
    <div class="col-6 col-lg-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted">Selesai</div><div class="h3 mb-0 text-success">{{ $complaintSummary['resolved'] }}</div></div></div></div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold">Pengaduan Terbaru</div>
    @if ($recentComplaints->isEmpty())
        <div class="card-body text-muted">Belum ada pengaduan.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>Pengguna</th><th>Subjek</th><th>Status</th><th>Dikirim</th><th></th></tr></thead>
                <tbody>
                    @foreach ($recentComplaints as $complaint)
                        <tr>
                            <td>{{ $complaint->user->name }}</td>
                            <td>{{ $complaint->subject }}</td>
                            <td>{{ str_replace('_', ' ', ucfirst($complaint->status)) }}</td>
                            <td>{{ $complaint->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end"><a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-sm btn-outline-primary">Tangani</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    </div>
@endsection