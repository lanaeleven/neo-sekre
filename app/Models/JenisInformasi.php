<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisInformasi extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'jenis_informasi';

    public function informasi(): HasMany {
        return $this->hasMany(JenisInformasi::class, 'idJenisInformasi');
    }
}
