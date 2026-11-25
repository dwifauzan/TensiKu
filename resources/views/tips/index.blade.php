<x-layouts.app title="Tips Kesehatan">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Tips Kesehatan</h1>
            <p class="mt-2 text-muted">Panduan gaya hidup dan pola makan sesuai kondisi tekanan darah Anda.</p>
        </div>

        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.tips.index') }}"
               class="rounded-xl bg-cuff px-5 py-3 font-semibold text-white">
                Kelola Tips (Admin)
            </a>
        @endif
    </div>

    {{-- Filter Kategori & Pencarian --}}
    <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('tips.index') }}"
               class="rounded-full px-4 py-2 text-sm font-medium {{ !$kategoriAktif ? 'bg-cuff text-white' : 'border border-line bg-white text-gray-700' }}">
                Semua
            </a>
            <a href="{{ route('tips.index', ['kategori' => 'umum', 'cari' => $cari]) }}"
               class="rounded-full px-4 py-2 text-sm font-medium {{ $kategoriAktif === 'umum' ? 'bg-cuff text-white' : 'border border-line bg-white text-gray-700' }}">
                Tips Umum
            </a>
            @foreach($daftarKategori as $key => $label)
                <a href="{{ route('tips.index', ['kategori' => $key, 'cari' => $cari]) }}"
                   class="rounded-full px-4 py-2 text-sm font-medium {{ $kategoriAktif === $key ? 'bg-cuff text-white' : 'border border-line bg-white text-gray-700' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <form action="{{ route('tips.index') }}" method="GET" class="flex gap-2">
            @if($kategoriAktif)
                <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
            @endif
            <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari tips kesehatan..."
                   class="rounded-xl border border-line bg-white px-4 py-2 text-sm">
            <button type="submit" class="rounded-xl bg-cuff px-4 py-2 text-sm font-semibold text-white">
                Cari
            </button>
        </form>
    </div>

    {{-- Grid Kartu Tips --}}
    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($tips as $tip)
            <article class="flex flex-col overflow-hidden rounded-xl border border-line bg-white">
                @if($tip->gambar)
                    <img src="{{ asset('storage/' . $tip->gambar) }}" alt="{{ $tip->judul }}"
                         class="h-44 w-full object-cover">
                @endif

                <div class="flex flex-1 flex-col justify-between p-5">
                    <div>
                        <span class="inline-block rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                            {{ $tip->kategori_label }}
                        </span>

                        <h2 class="mt-3 text-lg font-bold">
                            <a href="{{ route('tips.show', $tip) }}" class="hover:underline">
                                {{ $tip->judul }}
                            </a>
                        </h2>

                        <p class="mt-2 text-sm text-muted">
                            {{ \Illuminate\Support\Str::limit(strip_tags($tip->isi), 120) }}
                        </p>
                    </div>

                    <div class="mt-4 flex items-center justify-between border-t border-line pt-3 text-xs text-muted">
                        <span>{{ $tip->created_at->format('d M Y') }}</span>
                        <a href="{{ route('tips.show', $tip) }}" class="font-semibold text-blue-600 hover:underline">
                            Baca Selengkapnya &rarr;
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-xl border border-line bg-white p-8 text-center text-muted">
                Belum ada tips kesehatan yang tersedia untuk kategori ini.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $tips->links() }}
    </div>
</x-layouts.app>