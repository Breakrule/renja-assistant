<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\RenjaSubsection;

class RenjaSection extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'renja_id',
        'kode_bab',
        'judul',
        'urutan',
    ];

    public function renja()
    {
        return $this->belongsTo(Renja::class);
    }

    public function subsections()
    {
        return $this->hasMany(RenjaSubsection::class);
    }
}


