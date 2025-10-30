<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function mengirimDS(): HasMany
    {
        return $this->hasMany(DistribusiSurat::class, 'idPengirimDisposisi');
    }

    public function menerimaDS(): HasMany
    {
        return $this->hasMany(DistribusiSurat::class, 'idTujuanDisposisi');
    }

    public function senderPengirimKhusus(): HasMany
    {
        return $this->hasMany(PengirimKhusus::class, 'idUser');
    }

    public function receiverPengirimKhusus(): HasMany
    {
        return $this->hasMany(PengirimKhusus::class, 'bisaMengirimKe');
    }

    public function receiverPenerimaKhusus(): HasMany
    {
        return $this->hasMany(PenerimaKhusus::class, 'idUser');
    }

    public function senderPenerimaKhusus(): HasMany
    {
        return $this->hasMany(PenerimaKhusus::class, 'bisaMenerimaDari');
    }

    public function isKepala(): HasOne
    {
        return $this->hasOne(UserKepala::class);
    }

    public function strukturOrganisasi()
    {
        return $this->hasOne(StrukturOrganisasi::class, 'idUser', 'id');
    }

    public function suratMasuk(): HasMany
    {
        return $this->hasMany(SuratMasuk::class, 'idPengirim');
    }

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class);
    }

    public function informasi(): BelongsToMany
    {
        return $this->belongsToMany(Informasi::class);
    }

    public function undangan(): BelongsToMany
    {
        return $this->belongsToMany(Undangan::class);
    }

    public function pks(): BelongsToMany
    {
        return $this->belongsToMany(PerjanjianKerjaSama::class);
    }
}
