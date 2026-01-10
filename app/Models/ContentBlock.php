<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    protected $fillable = [
        'renja_subsection_id',
        'content',
        'source',        // 'generated' | 'manual'
        'manual_locked', // bool
        'last_generated_at',
    ];

    protected $casts = [
        'manual_locked' => 'boolean',
        'last_generated_at' => 'datetime',
    ];

    public function subsection()
    {
        return $this->belongsTo(RenjaSubsection::class, 'renja_subsection_id');
    }
}
