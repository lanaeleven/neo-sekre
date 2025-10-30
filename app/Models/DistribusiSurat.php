<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DistribusiSurat extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'distribusi_surat';

    public $timestamps = false;

    public function pengirimDisposisi(): BelongsTo {
        return $this->belongsTo(User::class, 'idPengirimDisposisi');
    }

    public function tujuanDisposisi(): BelongsTo {
        return $this->belongsTo(User::class, 'idTujuanDisposisi');
    }

    public function suratMasuk(): BelongsTo {
        return $this->belongsTo(SuratMasuk::class, 'idSuratMasuk');
    }
}
