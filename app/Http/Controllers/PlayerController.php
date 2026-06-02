<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\School;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::with('school')->get();

        return view('players.index', compact('players'));
    }

    public function create()
    {
        $schools = School::all();

        return view('players.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'nama_pemain' => 'required',
            'posisi' => 'required'
        ]);

        Player::create([
            'school_id' => $request->school_id,
            'nama_pemain' => $request->nama_pemain,
            'posisi' => $request->posisi,
        ]);

        return redirect('/players')
            ->with('success', 'Pemain berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $player = Player::findOrFail($id);

        return view('players.show', compact('player'));
    }

    public function edit(string $id)
    {
        $player = Player::findOrFail($id);
        $schools = School::all();

        return view('players.edit', compact(
            'player',
            'schools'
        ));
    }

    public function update(Request $request, string $id)
    {
        $player = Player::findOrFail($id);

        $player->update([
            'school_id' => $request->school_id,
            'nama_pemain' => $request->nama_pemain,
            'posisi' => $request->posisi,
        ]);

        return redirect('/players')
            ->with('success', 'Pemain berhasil diupdate');
    }

    public function destroy(string $id)
    {
        Player::destroy($id);

        return redirect('/players')
            ->with('success', 'Pemain berhasil dihapus');
    }
}