<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Direksi extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'direksi';

    public $timestamps = false;

    public function suratKeluar(): HasMany {
        return $this->hasMany(SuratKeluar::class, 'idDireksi');
    }

    public function suratMasuk(): HasMany {
        return $this->hasMany(SuratMasuk::class, 'idDireksi');
    }

    public function spo(): HasMany {
        return $this->hasMany(Spo::class, 'idDireksi');
    }
}
