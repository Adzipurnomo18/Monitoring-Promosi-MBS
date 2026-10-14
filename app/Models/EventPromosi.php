<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventPromosi extends Model
{
    use HasFactory;

    protected $table = 'event_promosi';

    protected $fillable = [
        'nama_event',
        'tahun',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'tahun' => 'integer',
        ];
    }

    public function programPromos(): HasMany
    {
        return $this->hasMany(ProgramPromo::class);
    }
}
