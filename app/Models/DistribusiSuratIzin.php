<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistribusiSuratIzin extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'distribusi_surat_izin';

    public $timestamps = false;

    public function pengirimDisposisi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idPengirimDisposisi');
    }

    public function tujuanDisposisi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idTujuanDisposisi');
    }

    public function suratIzin(): BelongsTo
    {
        return $this->belongsTo(SuratIzin::class, 'idSuratIzin');
    }
}
