<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::latest()->get();

        return view('admin.games.index', [
            'title' => 'Manajemen Game',
            'games' => $games,
        ]);
    }

    public function create()
    {
        return view('admin.games.create', [
            'title' => 'Tambah Game',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'currency' => 'required|string|max:100',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Game::create($validated);

        return redirect()
            ->route('admin.games.index')
            ->with('success', 'Game berhasil ditambahkan.');
    }

    public function show(Game $game)
    {
        $game->load('topupPackages');

        return view('games.show', [
            'title' => $game->name,
            'game' => $game,
        ]);
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', [
            'title' => 'Edit Game',
            'game' => $game,
        ]);
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'currency' => 'required|string|max:100',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $game->update($validated);

        return redirect()
            ->route('admin.games.index')
            ->with('success', 'Game berhasil diperbarui.');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()
            ->route('admin.games.index')
            ->with('success', 'Game berhasil dihapus.');
    }

    public function catalog()
    {
        $games = Game::with('topupPackages')
            ->where('is_active', true)
            ->get();

        return view('games.index', [
            'title' => 'Katalog Game',
            'games' => $games,
        ]);
    }

}