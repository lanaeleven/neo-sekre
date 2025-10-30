<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Undangan extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'undangan';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
