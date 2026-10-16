<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\TopupPackage;
use Illuminate\Http\Request;

class TopupPackageController extends Controller
{
    public function index()
    {
        $packages = TopupPackage::with('game')->get();

        return view('admin.packages.index', [
            'title' => 'Paket Top Up',
            'packages' => $packages,
        ]);
    }

    public function create()
    {
        $games = Game::all();

        return view('admin.packages.create', [
            'title' => 'Tambah Paket Top Up',
            'games' => $games,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'amount' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        TopupPackage::create([
            'game_id' => $request->game_id,
            'amount' => $request->amount,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket top up berhasil ditambahkan.');
    }

    public function show(TopupPackage $package)
    {
        $package->load('game');

        return view('admin.packages.show', [
            'title' => 'Detail Paket Top Up',
            'package' => $package,
        ]);
    }

    public function edit(TopupPackage $package)
    {
        $games = Game::all();

        return view('admin.packages.edit', [
            'title' => 'Edit Paket Top Up',
            'package' => $package,
            'games' => $games,
        ]);
    }

    public function update(Request $request, TopupPackage $package)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'amount' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $package->update([
            'game_id' => $request->game_id,
            'amount' => $request->amount,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket top up berhasil diperbarui.');
    }

    public function destroy(TopupPackage $package)
    {
        $package->delete();

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket top up berhasil dihapus.');
    }
}