<?php

namespace App\Domains\Planning\Rules;

use App\Models\Renja;

interface RuleInterface
{
    /**
     * Jalankan validasi alignment.
     *
     * @param Renja $renja
     * @return array hasil validasi (status, catatan)
     */
    public function validate(Renja $renja): array;
}
