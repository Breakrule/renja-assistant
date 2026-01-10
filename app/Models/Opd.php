<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    protected $fillable = [
        'kode_opd',
        'nama_opd',
        'urusan',
        'bidang',
    ];

    public function renjas()
    {
        return $this->hasMany(Renja::class);
    }
}
