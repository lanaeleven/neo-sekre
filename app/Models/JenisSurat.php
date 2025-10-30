<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSurat extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'jenis_surat';

    public $timestamps = false;

    public function suratKeluar(): HasMany {
        return $this->hasMany(SuratKeluar::class, 'idJenisSurat');
    }


}
