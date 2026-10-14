<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramPromoOutlet extends Model
{
    use HasFactory;

    protected $table = 'program_promo_outlet';

    protected $fillable = [
        'program_promo_id',
        'outlet_id',
        'status_realisasi_outlet',
        'nilai_alokasi',
        'tanggal_realisasi',
        'foto_bukti',
        'catatan_outlet',
    ];

    protected function casts(): array
    {
        return [
            'nilai_alokasi' => 'float',
            'tanggal_realisasi' => 'date',
        ];
    }

    public function programPromo(): BelongsTo
    {
        return $this->belongsTo(ProgramPromo::class);
    }

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }
}
