<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramAlignment extends Model
{
    protected $fillable = [
        'renja_program_id',
        'planning_goal_id',
        'status',
        'catatan',
    ];

    public function program()
    {
        return $this->belongsTo(RenjaProgram::class, 'renja_program_id');
    }
}
