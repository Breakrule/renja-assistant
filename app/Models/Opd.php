<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opd extends Model
{
    use HasFactory;
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
