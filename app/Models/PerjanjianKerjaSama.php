<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerjanjianKerjaSama extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $table = 'perjanjian_kerja_sama';


    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
