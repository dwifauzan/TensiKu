
@php
    $tanggalMulai = old('tanggal_mulai', isset($obat) ? $obat->tanggal_mulai?->format('Y-m-d') : '');
    $tanggalSelesai = old('tanggal_selesai', isset($obat) ? $obat->tanggal_selesai?->format('Y-m-d') : '');
@endphp

@foreach([
    'nama_obat' => ['Nama Obat', 'Amlodipine', 'Tulis nama sesuai kemasan atau resep.'],
    'dosis' => ['Dosis', '5 mg atau 1 tablet', 'Jumlah obat untuk sekali minum.'],
    'aturan_pakai' => ['Aturan Pakai', 'Sesudah makan', 'Petunjuk minum dari dokter atau kemasan.'],
    'frekuensi' => ['Frekuensi', '1 kali sehari', 'Seberapa sering obat diminum.'],
    'waktu_minum' => ['Waktu Minum', 'Pagi atau 08.00', 'Kapan biasanya obat diminum.'],
] as $field => [$label, $contoh, $petunjuk])
    <div>
        <label for="{{ $field }}" class="mb-2 block font-semibold">{{ $label }}</label>
        <input type="text" id="{{ $field }}" name="{{ $field }}" placeholder="Contoh: {{ $contoh }}"
               value="{{ old($field, $obat->$field ?? '') }}"
               required
               aria-describedby="{{ $field }}-help @error($field) {{ $field }}-error @enderror"
               @error($field) aria-invalid="true" @enderror
               class="w-full rounded-xl border border-line px-4 py-3">
        <p id="{{ $field }}-help" class="mt-1 text-sm text-muted">{{ $petunjuk }}</p>
        @error($field)
            <p id="{{ $field }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
@endforeach

<div>
    <label for="tanggal_mulai" class="mb-2 block font-semibold">Tanggal Mulai</label>
    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ $tanggalMulai }}"
           aria-describedby="tanggal_mulai-help @error('tanggal_mulai') tanggal_mulai-error @enderror"
           @error('tanggal_mulai') aria-invalid="true" @enderror
           required class="w-full rounded-xl border border-line px-4 py-3">
    <p id="tanggal_mulai-help" class="mt-1 text-sm text-muted">Tanggal pertama mulai minum obat.</p>
    @error('tanggal_mulai')
        <p id="tanggal_mulai-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="tanggal_selesai" class="mb-2 block font-semibold">Tanggal Selesai (opsional)</label>
    <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ $tanggalSelesai }}"
           aria-describedby="tanggal_selesai-help @error('tanggal_selesai') tanggal_selesai-error @enderror"
           @error('tanggal_selesai') aria-invalid="true" @enderror
           class="w-full rounded-xl border border-line px-4 py-3">
    <p id="tanggal_selesai-help" class="mt-1 text-sm text-muted">Kosongkan jika belum tahu kapan berhenti. Tanggal ini tidak boleh sebelum tanggal mulai.</p>
    @error('tanggal_selesai')
        <p id="tanggal_selesai-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="catatan" class="mb-2 block font-semibold">Catatan (opsional)</label>
    <textarea id="catatan" name="catatan" rows="3" placeholder="Contoh: Bawa obat saat bepergian"
              aria-describedby="catatan-help @error('catatan') catatan-error @enderror"
              @error('catatan') aria-invalid="true" @enderror
              class="w-full rounded-xl border border-line px-4 py-3">{{ old('catatan', $obat->catatan ?? '') }}</textarea>
    <p id="catatan-help" class="mt-1 text-sm text-muted">Tambahkan pengingat pribadi jika perlu.</p>
    @error('catatan')
        <p id="catatan-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
