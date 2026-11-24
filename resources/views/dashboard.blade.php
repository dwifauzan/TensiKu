
<x-layouts.app title="Dashboard">
    <h1 class="text-3xl font-extrabold tracking-tight">
        Halo, {{ str(auth()->user()->nama)->before(' ') }}
    </h1>

    <p class="mt-2 text-muted">
        Selamat datang di TensiKu.
    </p>

    {{-- Widget Obat Hari Ini --}}
    <div class="mt-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold">Obat Hari Ini</h2>
                <p class="mt-1 text-sm text-muted">
                    Daftar obat yang sedang dikonsumsi.
                </p>
            </div>

            <a href="{{ route('obat.index') }}"
               class="text-sm font-semibold text-blue-700">
                Lihat Semua
            </a>
        </div>

        <div class="mt-4 space-y-3">
            @forelse($obatHariIni as $item)
                <div class="rounded-xl border border-line bg-white p-5">
                    <h3 class="font-bold text-lg">
                        {{ $item->nama_obat }}
                    </h3>

                    <p class="mt-1 text-sm text-muted">
                        Dosis: {{ $item->dosis }}
                    </p>

                    <p class="text-sm text-muted">
                        Frekuensi: {{ $item->frekuensi }}
                    </p>

                    <p class="text-sm text-muted">
                        Waktu minum: {{ $item->waktu_minum }}
                    </p>

                    <span class="mt-3 inline-block rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                        Aktif
                    </span>
                </div>
            @empty
                <div class="rounded-xl border border-dashed border-line bg-white p-6 text-center">
                    <p class="font-semibold">
                        Belum ada jadwal obat hari ini.
                    </p>

                    <p class="mt-2 text-sm text-muted">
                        Tambahkan catatan obat untuk melihatnya di sini.
                    </p>

                    <a href="{{ route('obat.create') }}"
                       class="mt-4 inline-block rounded-xl bg-cuff px-5 py-3 text-sm font-semibold text-white">
                        + Tambah Obat
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
