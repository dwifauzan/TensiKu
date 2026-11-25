<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TipController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $tips = Tip::with('pembuat')->latest()->paginate(10);

        return view('admin.tips.index', compact('tips'));
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        return view('admin.tips.create', [
            'daftarKategori' => Tip::KATEGORI,
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|in:normal,meningkat,hipertensi_1,hipertensi_2',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('tips', 'public');
        }

        $data['dibuat_oleh'] = auth()->id();

        Tip::create($data);

        return redirect()->route('admin.tips.index')
            ->with('success', 'Tips kesehatan berhasil ditambahkan.');
    }

    public function edit(Tip $tip)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        return view('admin.tips.edit', [
            'tip' => $tip,
            'daftarKategori' => Tip::KATEGORI,
        ]);
    }

    public function update(Request $request, Tip $tip)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|in:normal,meningkat,hipertensi_1,hipertensi_2',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($tip->gambar) {
                Storage::disk('public')->delete($tip->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('tips', 'public');
        }

        $tip->update($data);

        return redirect()->route('admin.tips.index')
            ->with('success', 'Tips kesehatan berhasil diperbarui.');
    }

    public function destroy(Tip $tip)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        if ($tip->gambar) {
            Storage::disk('public')->delete($tip->gambar);
        }

        $tip->delete();

        return redirect()->route('admin.tips.index')
            ->with('success', 'Tips kesehatan berhasil dihapus.');
    }
}