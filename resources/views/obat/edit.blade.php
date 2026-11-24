
<x-layouts.app title="Edit Obat">
    <h1 class="text-3xl font-bold">Edit Catatan Obat</h1>

    <form action="{{ route('obat.update', $obat) }}" method="POST"
          class="mt-8 space-y-5 rounded-xl border border-line bg-white p-6">
        @csrf
        @method('PUT')

        @include('obat.form')

        <button type="submit"
                class="rounded-xl bg-cuff px-5 py-3 text-white font-semibold">
            Simpan Perubahan
        </button>

        <a href="{{ route('obat.index') }}" class="ml-3 text-muted">
            Batal
        </a>
    </form>
</x-layouts.app>
