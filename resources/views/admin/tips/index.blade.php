<x-layouts.app title="Kelola Tips Kesehatan">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Kelola Tips Kesehatan</h1>
            <p class="mt-2 text-muted">Tambah, ubah, atau hapus konten edukasi tekanan darah untuk pengguna.</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('tips.index') }}"
               class="rounded-xl border border-line bg-white px-4 py-3 font-semibold">
                Lihat Tampilan User
            </a>
            <a href="{{ route('admin.tips.create') }}"
               class="rounded-xl bg-cuff px-5 py-3 font-semibold text-white">
                + Tambah Tips
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mt-5 rounded-xl bg-green-100 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-6 overflow-x-auto rounded-xl border border-line bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-line bg-gray-50 font-semibold">
                <tr>
                    <th class="p-4">Judul</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Pembuat</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tips as $tip)
                    <tr>
                        <td class="p-4 font-medium">{{ $tip->judul }}</td>
                        <td class="p-4">
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                {{ $tip->kategori_label }}
                            </span>
                        </td>
                        <td class="p-4 text-muted">{{ $tip->pembuat?->nama ?? '-' }}</td>
                        <td class="p-4 text-muted">{{ $tip->created_at->format('d-m-Y') }}</td>
                        <td class="p-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.tips.edit', $tip) }}"
                                   class="rounded-lg bg-blue-100 px-3 py-1.5 text-blue-700">
                                    Edit
                                </a>
                                <form action="{{ route('admin.tips.destroy', $tip) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus tips ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg bg-red-100 px-3 py-1.5 text-red-700">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-muted">
                            Belum ada data tips kesehatan. Klik "+ Tambah Tips" untuk membuat yang pertama.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tips->links() }}
    </div>
</x-layouts.app>