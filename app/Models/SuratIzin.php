<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratIzin extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'surat_izin';

    public $timestamps = false;

    public function distribusiSurat(): HasMany
    {
        return $this->hasMany(DistribusiSuratIzin::class, 'idSuratIzin');
    }

    public function userPengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idPengirim');
    }
}
