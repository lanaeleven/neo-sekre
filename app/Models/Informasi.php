<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Informasi extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'informasi';

    public function jenisInformasi(): BelongsTo {
        return $this->belongsTo(JenisInformasi::class, 'idJenisInformasi');
    }

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
