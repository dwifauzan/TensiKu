
<x-layouts.app title="Catatan Obat">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Catatan Obat</h1>
            <p class="mt-2 text-muted">Kelola catatan obatmu.</p>
        </div>

        <a href="{{ route('obat.create') }}"
           class="rounded-xl bg-cuff px-5 py-3 text-white font-semibold">
            + Tambah Obat
        </a>
    </div>

    @if(session('success'))
        <div class="mt-5 rounded-xl bg-green-100 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-8 grid gap-4 sm:grid-cols-2">
        <div class="rounded-xl border border-line bg-white p-5">
            <p>Obat Aktif</p>
            <h2 class="text-3xl font-bold">
                {{ $obat->where('aktif', true)->count() }}
            </h2>
        </div>

        <div class="rounded-xl border border-line bg-white p-5">
            <p>Obat Selesai</p>
            <h2 class="text-3xl font-bold">
                {{ $obat->where('aktif', false)->count() }}
            </h2>
        </div>
    </div>

    <h2 class="mt-8 mb-4 text-xl font-bold">Daftar Obat</h2>

    @forelse($obat as $item)
        <div class="mb-4 rounded-xl border border-line bg-white p-5">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-bold">{{ $item->nama_obat }}</h3>
                    <p class="text-sm text-muted">Dosis: {{ $item->dosis }}</p>
                    <p class="text-sm text-muted">Aturan pakai: {{ $item->aturan_pakai }}</p>
                    <p class="text-sm text-muted">Frekuensi: {{ $item->frekuensi }}</p>
                    <p class="text-sm text-muted">Waktu minum: {{ $item->waktu_minum }}</p>
                    <p class="text-sm text-muted">
                        Mulai: {{ $item->tanggal_mulai?->format('d-m-Y') ?? '-' }}
                    </p>
                    <p class="text-sm text-muted">
                        Selesai: {{ $item->tanggal_selesai?->format('d-m-Y') ?? '-' }}
                    </p>

                    @if($item->catatan)
                        <p class="mt-2">{{ $item->catatan }}</p>
                    @endif
                </div>

                <span class="text-sm font-semibold">
                    {{ $item->aktif ? 'Aktif' : 'Selesai' }}
                </span>
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('obat.edit', $item) }}"
                   class="rounded-lg bg-blue-100 px-4 py-2 text-blue-700">
                    Edit
                </a>

                @if($item->aktif)
                    <form action="{{ route('obat.selesai', $item) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="rounded-lg bg-green-100 px-4 py-2 text-green-700">
                            Tandai Selesai
                        </button>
                    </form>
                @endif

                <form action="{{ route('obat.destroy', $item) }}" method="POST"
                      onsubmit="return confirm('Hapus catatan obat ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg bg-red-100 px-4 py-2 text-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="rounded-xl border border-line bg-white p-8 text-center">
            Belum ada catatan obat. Silakan tambahkan obat.
        </div>
    @endforelse
</x-layouts.app>
