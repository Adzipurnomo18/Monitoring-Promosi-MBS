<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'kategori',
        'kontak_person',
        'email',
        'telepon',
        'status_customer_ar',
        'status_alamat_tagih',
        'is_active',
    ];

    public function programPromos(): HasMany
    {
        return $this->hasMany(ProgramPromo::class);
    }

    public function tagihanAr(): HasMany
    {
        return $this->hasMany(TagihanAr::class);
    }
}
