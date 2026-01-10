<?php

namespace App\Actions\Renja;

use App\Models\Renja;

class GenerateProgressSummaryAction
{
    public function execute(Renja $renja): array
    {
        return $renja->progress()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }
}
