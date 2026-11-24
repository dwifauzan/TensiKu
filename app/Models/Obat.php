<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Obat extends Model
{
    protected $table = 'obat';

    protected $fillable = [
        'pengguna_id',
        'nama_obat',
        'dosis',
        'aturan_pakai',
        'frekuensi',
        'waktu_minum',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'aktif' => 'boolean',
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
}
