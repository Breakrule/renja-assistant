<?php

namespace App\Actions\Renja;

use App\Models\Renja;

class RejectRenjaAction
{
    public function execute(Renja $renja, string $catatan = null): Renja
    {
        if ($renja->status !== 'submitted') {
            throw new \RuntimeException('Renja belum diajukan.');
        }

        $renja->update([
            'status' => 'rejected',
        ]);

        // Catatan bisa ditambahkan nanti (log / komentar)
        return $renja;
    }
}
