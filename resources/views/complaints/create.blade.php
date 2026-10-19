@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold mb-0">Buat Pengaduan</h1>
            <a href="{{ route('complaints.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('complaints.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="transaction_id" class="form-label">Transaksi terkait <span class="text-muted">(opsional)</span></label>
                        <select name="transaction_id" id="transaction_id" class="form-select">
                            <option value="">Tidak terkait transaksi tertentu</option>
                            @foreach ($transactions as $transaction)
                                <option value="{{ $transaction->id }}" @selected(old('transaction_id') == $transaction->id)>
                                    {{ $transaction->invoice_code }} - {{ $transaction->game?->name ?? 'Game' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subjek</label>
                        <input type="text" name="subject" id="subject" maxlength="150" value="{{ old('subject') }}" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label for="message" class="form-label">Detail pengaduan</label>
                        <textarea name="message" id="message" rows="6" maxlength="10000" class="form-control" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection