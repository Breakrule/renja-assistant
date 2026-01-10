<?php

namespace App\Actions\Renja;

use App\Models\Renja;
use App\Models\RenjaSubsection;
use App\Models\RenjaProgress;


class UpdateSubsectionStatusAction
{
    public function execute(Renja $renja, RenjaSubsection $subsection, string $status): void
    {
        if (!in_array($status, ['draft', 'final'])) {
            return;
        }

        // proteksi OPD
        if (
            auth()->user()->hasRole('opd') &&
            $renja->opd_id !== auth()->user()->opd_id
        ) {
            abort(403);
        }

        $subsection->update([
            'status' => $status,
        ]);
    }
}
