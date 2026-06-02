<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return view('schools.index', compact('schools'));
    }

    public function create()
    {
        return view('schools.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required'
        ]);

        School::create([
            'nama_sekolah' => $request->nama_sekolah
        ]);

        return redirect('/schools')
            ->with('success', 'Sekolah berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $school = School::findOrFail($id);
        return view('schools.show', compact('school'));
    }

    public function edit(string $id)
    {
        $school = School::findOrFail($id);
        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_sekolah' => 'required'
        ]);

        $school = School::findOrFail($id);

        $school->update([
            'nama_sekolah' => $request->nama_sekolah
        ]);

        return redirect('/schools')
            ->with('success', 'Sekolah berhasil diupdate');
    }

    public function destroy(string $id)
    {
        School::destroy($id);

        return redirect('/schools')
            ->with('success', 'Sekolah berhasil dihapus');
    }
}