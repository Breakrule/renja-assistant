<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RenjaSubsection;

class RenjaSection extends Model
{
    use HasFactory;
    
    // Timestamps disabled as this is structural/configuration data that doesn't need tracking
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


