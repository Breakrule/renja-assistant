<?php

namespace App\Actions\Renja;

use App\Models\Renja;

class SubmitRenjaAction
{
    public function execute(Renja $renja): Renja
    {
        if ($renja->status !== 'draft' && $renja->status !== 'rejected') {
            throw new \RuntimeException('Renja tidak bisa diajukan.');
        }

        // Validasi: semua sub-bab harus final
        if (!$renja->canBeFinal()) {
            throw new \RuntimeException('Masih ada sub-bab yang belum final.');
        }

        $renja->update([
            'status' => 'submitted',
        ]);

        return $renja;
    }
}
