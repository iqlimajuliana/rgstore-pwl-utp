<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\TopupPackage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function checkout(Request $request)
    {
        $games = Game::with(['topupPackages' => function ($query) {
            $query->where('is_active', true);
        }])->where('is_active', true)->get();

        $selectedGameId = $request->query('game_id');
        $selectedPackageId = $request->query('package_id');

        $paymentMethods = [
            'BCA' => 'Transfer Bank BCA',
            'Mandiri' => 'Transfer Bank Mandiri',
            'BRI' => 'Transfer Bank BRI',
            'QRIS' => 'QRIS (Semua E-Wallet)',
            'DANA' => 'DANA Wallet',
            'GoPay' => 'GoPay Wallet',
        ];

        return view('transactions.checkout', [
            'title' => 'Checkout Top Up',
            'games' => $games,
            'selectedGameId' => $selectedGameId,
            'selectedPackageId' => $selectedPackageId,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'package_id' => 'required|exists:topup_packages,id',
            'user_game_id' => 'required|string|max:100',
            'zone_id' => 'nullable|string|max:50',
            'payment_method' => 'required|string|max:50',
        ]);

        $package = TopupPackage::where('id', $request->package_id)
            ->where('game_id', $request->game_id)
            ->where('is_active', true)
            ->firstOrFail();

        $invoiceCode = 'RGS-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $transaction = Transaction::create([
            'invoice_code' => $invoiceCode,
            'user_id' => Auth::id(),
            'game_id' => $request->game_id,
            'package_id' => $package->id,
            'user_game_id' => $request->user_game_id,
            'zone_id' => $request->zone_id,
            'payment_method' => $request->payment_method,
            'amount' => $package->amount,
            'total_price' => $package->price,
            'status' => 'pending',
        ]);

        return redirect()->route('transactions.payment', $transaction->id)
            ->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
    }

    public function payment(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('transactions.history')
                ->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $transaction->load(['game', 'package']);

        return view('transactions.payment', [
            'title' => 'Pembayaran - ' . $transaction->invoice_code,
            'transaction' => $transaction,
        ]);
    }

    public function pay(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('transactions.history')
                ->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
        }

        if ($transaction->status !== 'pending') {
            return redirect()->route('transactions.show', $transaction->id)
                ->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        $transaction->update([
            'status' => 'success',
        ]);

        return redirect()->route('transactions.show', $transaction->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda telah selesai.');
    }

    public function cancel(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('transactions.history')
                ->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
        }

        if ($transaction->status !== 'pending') {
            return redirect()->route('transactions.show', $transaction->id)
                ->with('error', 'Hanya pesanan pending yang dapat dibatalkan.');
        }

        $transaction->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('transactions.history')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function history()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with(['game', 'package'])
            ->latest()
            ->get();

        return view('transactions.history', [
            'title' => 'Riwayat Transaksi',
            'transactions' => $transactions,
        ]);
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('transactions.history')
                ->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $transaction->load(['game', 'package', 'user']);

        return view('transactions.show', [
            'title' => 'Detail Transaksi ' . $transaction->invoice_code,
            'transaction' => $transaction,
        ]);
    }
}
