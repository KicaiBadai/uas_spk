<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    public function index()
    {
        $criteria = Criterion::all();

        return view('criteria.index', compact('criteria'));
    }

    public function create()
    {
        return view('criteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama_kriteria' => 'required',
            'bobot' => 'required|numeric',
            'tipe' => 'required'
        ]);

        Criterion::create($request->all());

        return redirect('/criteria')
            ->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $criterion = Criterion::findOrFail($id);

        return view('criteria.edit', compact('criterion'));
    }

    public function update(Request $request, string $id)
    {
        $criterion = Criterion::findOrFail($id);

        $criterion->update([
            'kode' => $request->kode,
            'nama_kriteria' => $request->nama_kriteria,
            'bobot' => $request->bobot,
            'tipe' => $request->tipe,
        ]);

        return redirect('/criteria')
            ->with('success', 'Kriteria berhasil diupdate');
    }

    public function destroy(string $id)
    {
        Criterion::destroy($id);

        return redirect('/criteria')
            ->with('success', 'Kriteria berhasil dihapus');
    }
}