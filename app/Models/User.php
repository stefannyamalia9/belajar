<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable;

    protected $fillable     = [
        'name',
        'username',
        'email',
        'password',
        'status',
        'isguru'
    ];

    protected $guarded = [];
    public $timestamps      = false;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function roles()
    {
        return $this->belongsToMany(Roles::class);
    }

    public function hafalan_ayat(){
        return $this->hasMany(AyatHafalan::class, 'user_id');
    }

    public function hafalan_surah(){
        return $this->hasMany(SurahHafalan::class, 'user_id');
    }
}
