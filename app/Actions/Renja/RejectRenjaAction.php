<?php

namespace App\Actions\Renja;

use App\Models\Renja;

class RejectRenjaAction
{
    public function execute(Renja $renja): Renja
    {
        if ($renja->status !== 'submitted') {
            throw new \RuntimeException('Renja belum diajukan.');
        }

        $renja->update([
            'status' => 'rejected',
        ]);

        // TODO: Implement rejection notes/comments system if needed
        return $renja;
    }
}
