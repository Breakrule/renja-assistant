<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'opd_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // RELASI KE OPD
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
