<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetodeKesepakatan extends Model
{
    use HasFactory;

    protected $table = 'metode_kesepakatan';

    protected $fillable = [
        'kode_metode',
        'nama_metode',
        'deskripsi',
    ];

    public function programPromos(): HasMany
    {
        return $this->hasMany(ProgramPromo::class);
    }
}
