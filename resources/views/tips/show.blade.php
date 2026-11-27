<x-layouts.app :title="$tip->judul">
    <div class="mb-4">
        <a href="{{ route('tips.index') }}" class="text-sm font-semibold text-blue-600 hover:underline">
            &larr; Kembali ke Daftar Tips
        </a>
    </div>

    <article class="rounded-xl border border-line bg-white p-6 md:p-8">
        <span class="inline-block rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
            {{ $tip->kategori_label }}
        </span>

        <h1 class="mt-3 text-2xl font-bold md:text-3xl">{{ $tip->judul }}</h1>

        <p class="mt-2 text-sm text-muted">
            Ditulis oleh {{ $tip->pembuat?->nama ?? 'Admin TensiKu' }} &bull; {{ $tip->created_at->format('d F Y') }}
        </p>

        @if($tip->gambar)
            <img src="{{ asset('storage/' . $tip->gambar) }}" alt="{{ $tip->judul }}"
                 class="mt-6 max-h-96 w-full rounded-xl object-cover">
        @endif

        <div class="mt-6 space-y-4 leading-relaxed text-gray-800">
            {!! nl2br(e($tip->isi)) !!}
        </div>
    </article>

    @if($tipsTerkait->isNotEmpty())
        <section class="mt-8">
            <h2 class="mb-4 text-xl font-bold">Tips Terkait Lainnya</h2>
            <div class="grid gap-4 sm:grid-cols-3">
                @foreach($tipsTerkait as $item)
                    <a href="{{ route('tips.show', $item) }}"
                       class="rounded-xl border border-line bg-white p-4 hover:border-blue-400">
                        <span class="text-xs font-semibold text-blue-600">{{ $item->kategori_label }}</span>
                        <h3 class="mt-1 font-bold">{{ $item->judul }}</h3>
                        <p class="mt-1 text-xs text-muted">{{ \Illuminate\Support\Str::limit($item->isi, 80) }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.app>