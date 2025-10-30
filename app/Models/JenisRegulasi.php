<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisRegulasi extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'jenis_regulasi';

    public function regulasi(): HasMany {
        return $this->hasMany(JenisRegulasi::class, 'idJenisRegulasi');
    }
}
