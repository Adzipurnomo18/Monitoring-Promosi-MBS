<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaranaPromosi extends Model
{
    use HasFactory;

    protected $table = 'sarana_promosi';

    protected $fillable = [
        'kode_sarana',
        'nama_sarana',
        'kategori_sarana',
        'lokasi',
        'tarif_standar',
    ];

    protected function casts(): array
    {
        return [
            'tarif_standar' => 'float',
        ];
    }
}
