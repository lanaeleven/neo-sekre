<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $table = 'surat_masuk';

    public function distribusiSurat(): HasMany
    {
        return $this->hasMany(DistribusiSurat::class, 'idSuratMasuk');
    }

    public function userPengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idPengirim');
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSuratMasuk::class, 'idJenisSurat');
    }
}
