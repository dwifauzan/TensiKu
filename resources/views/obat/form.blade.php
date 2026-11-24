
@php
    $tanggalMulai = old('tanggal_mulai', isset($obat) ? $obat->tanggal_mulai?->format('Y-m-d') : '');
    $tanggalSelesai = old('tanggal_selesai', isset($obat) ? $obat->tanggal_selesai?->format('Y-m-d') : '');
@endphp

@foreach([
    'nama_obat' => 'Nama Obat',
    'dosis' => 'Dosis',
    'aturan_pakai' => 'Aturan Pakai',
    'frekuensi' => 'Frekuensi',
    'waktu_minum' => 'Waktu Minum',
] as $field => $label)
    <div>
        <label class="mb-2 block font-semibold">{{ $label }}</label>
        <input type="text" name="{{ $field }}"
               value="{{ old($field, $obat->$field ?? '') }}"
               required
               class="w-full rounded-xl border border-line px-4 py-3">
        @error($field)
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
@endforeach

<div>
    <label class="mb-2 block font-semibold">Tanggal Mulai</label>
    <input type="date" name="tanggal_mulai" value="{{ $tanggalMulai }}"
           required class="w-full rounded-xl border border-line px-4 py-3">
</div>

<div>
    <label class="mb-2 block font-semibold">Tanggal Selesai</label>
    <input type="date" name="tanggal_selesai" value="{{ $tanggalSelesai }}"
           class="w-full rounded-xl border border-line px-4 py-3">
</div>

<div>
    <label class="mb-2 block font-semibold">Catatan</label>
    <textarea name="catatan" rows="3"
              class="w-full rounded-xl border border-line px-4 py-3">{{ old('catatan', $obat->catatan ?? '') }}</textarea>
</div>
