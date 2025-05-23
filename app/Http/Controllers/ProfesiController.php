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

        return response()->json(['message' => 'Profesi berhasil diperbarui!']); // Changed success message
    }

    public function destroy($id)
    {
        Profesi::destroy($id);
        return redirect()->route('profesi.index')->with('success', 'Profesi berhasil dihapus!');
    }


    public function getByKategori(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string'
        ]);

        $profesi = Profesi::where('kategori', $request->kategori)
            ->orderBy('nama_profesi')
            ->get();

        return response()->json($profesi);
    }

    public function getAllKategori()
    {
        $kategori = Profesi::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->get()
            ->pluck('kategori');

        return response()->json($kategori->toArray());
    }
}
