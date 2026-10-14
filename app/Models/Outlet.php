<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Outlet extends Model
{
    use HasFactory;

    protected $table = 'outlet';

    protected $fillable = [
        'perusahaan_id',
        'nama_outlet',
        'ou_code',
        'kota',
        'is_active',
    ];

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function programPromoOutlets(): HasMany
    {
        return $this->hasMany(ProgramPromoOutlet::class);
    }

    public function tagihanAr(): HasMany
    {
        return $this->hasMany(TagihanAr::class);
    }
}
