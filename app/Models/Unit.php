<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $table = 'unit';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function spo(): BelongsToMany
    {
        return $this->belongsToMany(SPO::class);
    }

    public function regulasi(): BelongsToMany
    {
        return $this->belongsToMany(Regulasi::class);
    }

    public function pks(): BelongsToMany
    {
        return $this->belongsToMany(PerjanjianKerjaSama::class);
    }

    public function informasi(): BelongsToMany
    {
        return $this->belongsToMany(Informasi::class);
    }
}
