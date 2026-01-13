<?php

namespace App\Actions\Renja;

use App\Models\Renja;

class ApproveRenjaAction
{
    public function execute(Renja $renja): Renja
    {
        if ($renja->status !== 'submitted') {
            throw new \RuntimeException('Renja belum diajukan.');
        }

        $renja->update([
            'status' => 'approved',
        ]);

        return $renja;
    }
}
