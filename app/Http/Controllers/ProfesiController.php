<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesi;

class ProfesiController extends Controller
{
    public function index()
    {
        $profesis = Profesi::all();
        return view('dashboard.profesi', compact('profesis'));
    }

    public function create()
    {
        return view('dashboard.createProfesi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_profesi' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
        ]);

        Profesi::create([
            'nama_profesi' => $request->nama_profesi,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('profesi.index')->with('success', 'Profesi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $profesi = Profesi::findOrFail($id);
        return view('dashboard.editProfesi', compact('profesi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_profesi' => 'required|string|max:255',
            'kategori' => 'required|in:Infokom,Non-Infokom',
        ]);

        $profesi = Profesi::findOrFail($id);
        $profesi->update([
            'nama_profesi' => $request->nama_profesi,
            'kategori' => $request->kategori,
        ]);

        return response()->json(['message' => 'Berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $profesi = Profesi::findOrFail($id);
        $profesi->delete();

        return redirect()->route('profesi.index')->with('success', 'Profesi berhasil dihapus.');
    }
}
