<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'struktur_organisasi';

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function atasan(): BelongsTo {
        return $this->belongsTo(User::class, 'idAtasan');
    }

}
