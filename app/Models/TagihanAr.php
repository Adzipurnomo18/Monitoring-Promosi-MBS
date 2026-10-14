<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagihanAr extends Model
{
    use HasFactory;

    protected $table = 'tagihan_ar';

    protected $fillable = [
        'nomor_invoice',
        'program_promo_id',
        'supplier_id',
        'outlet_id',
        'tanggal_invoice',
        'tanggal_jatuh_tempo',
        'total_tagihan',
        'jumlah_terbayar',
        'status_pembayaran',
        'hari_keterlambatan',
        'nomor_oracle_ar',
        'metode_pembayaran',
        'tanggal_lunas',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_invoice' => 'date',
            'tanggal_jatuh_tempo' => 'date',
            'tanggal_lunas' => 'date',
            'total_tagihan' => 'float',
            'jumlah_terbayar' => 'float',
            'hari_keterlambatan' => 'integer',
        ];
    }

    public function programPromo(): BelongsTo
    {
        return $this->belongsTo(ProgramPromo::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }
}
