
<x-layouts.app title="Tambah Obat">
    <h1 class="text-3xl font-bold">Tambah Obat</h1>
    <p class="mt-2 text-muted">Masukkan informasi obat.</p>

    <form action="{{ route('obat.store') }}" method="POST"
          class="mt-8 space-y-5 rounded-xl border border-line bg-white p-6">
        @csrf

        @include('obat.form')

        <button type="submit"
                class="rounded-xl bg-cuff px-5 py-3 text-white font-semibold">
            Simpan Obat
        </button>

        <a href="{{ route('obat.index') }}"
           class="ml-3 text-muted">Batal</a>
    </form>
</x-layouts.app>
