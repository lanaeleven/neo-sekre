<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenerimaKhusus extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'id'
    ];

    protected $table = 'penerima_khusus';

    public function penerima(): BelongsTo {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function pengirim(): BelongsTo {
        return $this->belongsTo(User::class, 'bisaMenerimaDari');
    }
}
