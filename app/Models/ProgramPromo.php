<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramPromo extends Model
{
    use HasFactory;

    protected $table = 'program_promo';

    protected $fillable = [
        'nomor_program',
        'judul_program',
        'tahun',
        'supplier_id',
        'event_promosi_id',
        'metode_kesepakatan_id',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_nilai',
        'nilai_realisasi',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'total_nilai' => 'float',
            'nilai_realisasi' => 'float',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function eventPromosi(): BelongsTo
    {
        return $this->belongsTo(EventPromosi::class);
    }

    public function metodeKesepakatan(): BelongsTo
    {
        return $this->belongsTo(MetodeKesepakatan::class);
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
