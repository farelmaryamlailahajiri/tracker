<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesi;
use App\Models\Tracer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException; // Tambahkan ini

class ProfesiController extends Controller
{
    public function index()
    {
        $profesis = Profesi::select('profesi.*')
            ->selectRaw('EXISTS(SELECT 1 FROM tracer WHERE tracer.profesi_id = profesi.id) as is_used')
            ->get();

        return view('dashboard.profesi', compact('profesis'));
    }

    public function create()
    {
        return view('dashboard.createProfesi');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_profesi' => 'required|string|max:255',
                'kategori' => 'required|in:Infokom,Non-Infokom,Tidak Bekerja', // Pastikan kategori valid
            ]);

            Profesi::create([
                'nama_profesi' => $request->nama_profesi,
                'kategori' => $request->kategori,
            ]);

            // Mengembalikan respons JSON untuk konsistensi dengan AJAX/Fetch
            return response()->json([
                'status' => 'success',
                'message' => 'Profesi berhasil ditambahkan.'
            ]);
        } catch (ValidationException $e) {
            // Tangani error validasi dan kembalikan dalam format JSON
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422); // HTTP status 422 Unprocessable Entity
        } catch (\Exception $e) {
            Log::error('Error adding profesi: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan profesi.'
            ], 500);
        }
    }

    public function edit($id)
    {
        $profesi = Profesi::findOrFail($id);
        return response()->json($profesi);
    }

    public function update(Request $request, $id)
    {
        try {
            // Pastikan validasi mengembalikan JSON jika gagal
            $request->validate([
                'nama_profesi' => 'required|string|max:255',
                'kategori' => 'required|in:Infokom,Non-Infokom,Tidak Bekerja',
            ]);

            $profesi = Profesi::findOrFail($id);
            $profesi->update([
                'nama_profesi' => $request->nama_profesi,
                'kategori' => $request->kategori,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Profesi berhasil diperbarui!'
            ]);
        } catch (ValidationException $e) {
            // Tangani error validasi dan kembalikan dalam format JSON
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422); // HTTP status 422 Unprocessable Entity
        } catch (\Exception $e) {
            Log::error('Error updating profesi: ' . $e->getMessage(), ['profesi_id' => $id]);
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui profesi. Silakan coba lagi atau hubungi administrator.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $isUsed = DB::table('tracer')->where('profesi_id', $id)->exists();

            if ($isUsed) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Profesi tidak dapat dihapus karena sudah digunakan dalam data tracer.'
                ], 400);
            }

            Profesi::destroy($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Profesi berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting profesi: ' . $e->getMessage(), ['profesi_id' => $id]);
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus profesi. Silakan coba lagi atau hubungi administrator.'
            ], 500);
        }
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
