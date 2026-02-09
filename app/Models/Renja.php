<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Renja extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'opd_id',
        'tahun',
        'versi',
        'status',
        'created_by',
    ];

    /* =========================
     | RELATIONSHIPS
     ========================= */

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
    public function sections()
    {
        return $this->hasMany(RenjaSection::class);
    }

    public function programs()
    {
        return $this->hasMany(RenjaProgram::class);
    }

    public function programAlignments()
    {
        return $this->hasManyThrough(
            ProgramAlignment::class,
            RenjaProgram::class,
            'renja_id',           // FK di renja_programs
            'renja_program_id',   // FK di program_alignments
            'id',                 // PK renjas
            'id'                  // PK renja_programs
        );
    }

    /* =========================
     | BUSINESS RULE
     ========================= */

    public function canBeFinal(): bool
    {
        return !$this->sections()
            ->whereHas('subsections', function ($q) {
                $q->where('status', '!=', 'final');
            })
            ->exists();
    }

    public function progress()
    {
        return $this->hasMany(RenjaProgress::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
