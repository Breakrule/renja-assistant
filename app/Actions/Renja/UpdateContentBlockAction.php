<?php

namespace App\Actions\Renja;

use App\Models\ContentBlock;
use App\Models\ContentRevision;

class UpdateContentBlockAction
{
    public function execute(ContentBlock $block, string $newContent, int $userId): void
    {
        // simpan revisi
        ContentRevision::create([
            'content_block_id' => $block->id,
            'old_content' => $block->content,
            'new_content' => $newContent,
            'changed_by' => $userId,
        ]);

        // update konten utama
        $block->update([
            'content' => $newContent,
            'version' => $block->version + 1,
        ]);
    }
}
