<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentRevision extends Model
{
    use HasFactory;
    protected $fillable = [
        'content_block_id',
        'old_content',
        'new_content',
        'changed_by',
    ];

    protected function casts(): array
    {
        return [
            'content_block_id' => 'integer',
            'changed_by' => 'integer',
        ];
    }

    public function contentBlock()
    {
        return $this->belongsTo(ContentBlock::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
