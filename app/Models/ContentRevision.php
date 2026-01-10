<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentRevision extends Model
{
    protected $fillable = [
        'content_block_id',
        'old_content',
        'new_content',
        'changed_by',
    ];

    public function contentBlock()
    {
        return $this->belongsTo(ContentBlock::class);
    }
}
