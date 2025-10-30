<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengirimKhusus extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'pengirim_khusus';

    public function pengirim(): BelongsTo {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function penerima(): BelongsTo {
        return $this->belongsTo(User::class, 'bisaMengirimKe');
    }
}
