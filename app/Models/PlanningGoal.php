<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanningGoal extends Model
{
    protected $fillable = [
        'planning_document_id',
        'level',
        'parent_id',
        'kode',
        'uraian',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
