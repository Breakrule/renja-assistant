<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenjaProgress extends Model
{
    protected $fillable = [
        'renja_id',
        'renja_subsection_id',
        'status', // kosong | draft | reviewed | final
    ];

    public function renja()
    {
        return $this->belongsTo(Renja::class);
    }

    public function subsection()
    {
        return $this->belongsTo(RenjaSubsection::class, 'renja_subsection_id');
    }

}
