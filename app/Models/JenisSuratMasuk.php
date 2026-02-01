<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisSuratMasuk extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $table = 'jenis_surat_masuk';

    public $timestamps = false;

    public function SuratMasuk(): HasMany {
        return $this->hasMany(SuratMasuk::class, 'idJenisSurat');
    }

    
}
