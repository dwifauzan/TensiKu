<x-layouts.app title="Edit Tips Kesehatan">
    <div class="mb-4">
        <a href="{{ route('admin.tips.index') }}" class="text-sm font-semibold text-blue-600 hover:underline">
            &larr; Kembali ke Kelola Tips
        </a>
    </div>

    <div class="max-w-2xl rounded-xl border border-line bg-white p-6">
        <h1 class="text-2xl font-bold">Edit Tips Kesehatan</h1>

        <form action="{{ route('admin.tips.update', $tip) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold">Judul Tips</label>
                <input type="text" name="judul" value="{{ old('judul', $tip->judul) }}" required
                       class="mt-1 w-full rounded-xl border border-line px-4 py-2.5">
                @error('judul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold">Kategori Tekanan Darah</label>
                <select name="kategori" class="mt-1 w-full rounded-xl border border-line px-4 py-2.5">
                    <option value="" @selected(old('kategori', $tip->kategori) === null)>Tips Umum (Semua Pengguna)</option>
                    @foreach($daftarKategori as $key => $label)
                        <option value="{{ $key }}" @selected(old('kategori', $tip->kategori) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('kategori') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold">Isi Artikel Tips</label>
                <textarea name="isi" rows="7" required
                          class="mt-1 w-full rounded-xl border border-line px-4 py-2.5">{{ old('isi', $tip->isi) }}</textarea>
                @error('isi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold">Ganti Gambar (Opsional)</label>
                @if($tip->gambar)
                    <img src="{{ asset('storage/' . $tip->gambar) }}" alt="{{ $tip->judul }}"
                         class="my-2 h-32 rounded-lg object-cover">
                @endif
                <input type="file" name="gambar" accept="image/*" class="mt-1 block w-full text-sm">
                @error('gambar') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="rounded-xl bg-cuff px-6 py-2.5 font-semibold text-white">
                    Perbarui Tips
                </button>
                <a href="{{ route('admin.tips.index') }}"
                   class="rounded-xl border border-line px-6 py-2.5 font-semibold">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>