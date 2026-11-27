<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'dibuat_oleh',
        'judul',
        'isi',
        'kategori',
        'gambar',
    ];

    public const KATEGORI = [
        'normal' => 'Normal',
        'meningkat' => 'Meningkat (Pra-Hipertensi)',
        'hipertensi_1' => 'Hipertensi Tingkat 1',
        'hipertensi_2' => 'Hipertensi Tingkat 2',
    ];

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function scopeFilterKategori($query, ?string $kategori)
    {
        if ($kategori === 'umum') {
            return $query->whereNull('kategori');
        }

        if ($kategori && array_key_exists($kategori, self::KATEGORI)) {
            return $query->where('kategori', $kategori);
        }

        return $query;
    }

    public function getKategoriLabelAttribute(): string
    {
        if (is_null($this->kategori)) {
            return 'Tips Umum';
        }

        return self::KATEGORI[$this->kategori] ?? ucfirst($this->kategori);
    }
}