<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    // Menampilkan daftar obat
    public function index()
    {
        $obat = auth()->user()
            ->obat()
            ->latest()
            ->get();

        return view('obat.index', compact('obat'));
    }

    // Menampilkan form tambah obat
    public function create()
    {
        return view('obat.create');
    }

    // Menyimpan obat baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'dosis' => 'required|string|max:100',
            'aturan_pakai' => 'required|string|max:100',
            'frekuensi' => 'required|string|max:100',
            'waktu_minum' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'catatan' => 'nullable|string',
        ]);

        $data['aktif'] = true;

        auth()->user()->obat()->create($data);

        return redirect()->route('obat.index')
            ->with('success', 'Catatan obat berhasil ditambahkan.');
    }

    // Menampilkan form edit
    public function edit(Obat $obat)
    {
        abort_unless($obat->pengguna_id === auth()->id(), 403);

        return view('obat.edit', compact('obat'));
    }

    // Memperbarui obat
    public function update(Request $request, Obat $obat)
    {
        abort_unless($obat->pengguna_id === auth()->id(), 403);

        $data = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'dosis' => 'required|string|max:100',
            'aturan_pakai' => 'required|string|max:100',
            'frekuensi' => 'required|string|max:100',
            'waktu_minum' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'catatan' => 'nullable|string',
        ]);

        $obat->update($data);

        return redirect()->route('obat.index')
            ->with('success', 'Catatan obat berhasil diperbarui.');
    }

    // Menandai obat selesai
    public function selesai(Obat $obat)
    {
        abort_unless($obat->pengguna_id === auth()->id(), 403);

        $obat->update([
            'aktif' => false,
        ]);

        return back()->with('success', 'Obat berhasil ditandai selesai.');
    }

    // Menghapus catatan obat
    public function destroy(Obat $obat)
    {
        abort_unless($obat->pengguna_id === auth()->id(), 403);

        $obat->delete();

        return redirect()->route('obat.index')
            ->with('success', 'Catatan obat berhasil dihapus.');
    }
}
