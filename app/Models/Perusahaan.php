<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $fillable = [
        'kode_perusahaan',
        'nama_perusahaan',
    ];

    public function outlets(): HasMany
    {
        return $this->hasMany(Outlet::class);
    }
}
