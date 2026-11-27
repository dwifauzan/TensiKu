<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $cari = $request->query('cari');

        $tips = Tip::with('pembuat')
            ->filterKategori($kategori)
            ->when($cari, function ($query, $cari) {
                $query->where(function ($q) use ($cari) {
                    $q->where('judul', 'like', "%{$cari}%")
                      ->orWhere('isi', 'like', "%{$cari}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('tips.index', [
            'tips' => $tips,
            'kategoriAktif' => $kategori,
            'cari' => $cari,
            'daftarKategori' => Tip::KATEGORI,
        ]);
    }

    public function show(Tip $tip)
    {
        $tipsTerkait = Tip::where('id', '!=', $tip->id)
            ->where('kategori', $tip->kategori)
            ->latest()
            ->take(3)
            ->get();

        return view('tips.show', compact('tip', 'tipsTerkait'));
    }
}