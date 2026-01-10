<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenjaProgram extends Model
{
    protected $fillable = [
        'renja_id',
        'kode_program',
        'nama_program',
        'tujuan',
        'sasaran',
        'planning_goal_id',
    ];

    public function renja()
    {
        return $this->belongsTo(Renja::class);
    }

    public function alignments()
    {
        return $this->hasMany(ProgramAlignment::class);
    }
}
