<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regulasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $table = 'regulasi';

    public function jenisRegulasi(): BelongsTo
    {
        return $this->belongsTo(JenisRegulasi::class, 'idJenisRegulasi');
    }
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class);
    }
}
