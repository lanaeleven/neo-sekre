<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'surat_keluar';

    public $timestamps = false;

    public function jenisSurat(): BelongsTo {
        return $this->belongsTo(JenisSurat::class, 'idJenisSurat');
    }

    public function direksi(): BelongsTo {
        return $this->belongsTo(Direksi::class, 'idDireksi');
    }
}
