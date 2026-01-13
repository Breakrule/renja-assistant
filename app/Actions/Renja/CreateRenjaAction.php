<?php

namespace App\Actions\Renja;

use App\Models\Renja;
use Illuminate\Support\Facades\DB;

class CreateRenjaAction
{
    public function execute(
        int $tahun,
        int $opdId,
        int $createdBy,
        string $status = 'draft'
    ): Renja {

        // =========================
        // VALIDASI DOMAIN (WAJIB)
        // =========================
        if ($tahun < 2000 || $tahun > 2100) {
            throw new \InvalidArgumentException('Tahun Renja tidak valid.');
        }

        return DB::transaction(function () use ($tahun, $opdId, $createdBy, $status) {

            $latestVersion = Renja::withTrashed()
                ->where('opd_id', $opdId)
                ->where('tahun', $tahun)
                ->max('versi');

            $versi = $latestVersion ? $latestVersion + 1 : 1;

            $renja = Renja::create([
                'tahun' => $tahun,
                'opd_id' => $opdId,
                'created_by' => $createdBy,
                'status' => $status,
                'versi' => $versi,
            ]);

            (new GenerateRenjaStructureAction())->execute($renja);

            return $renja;
        });
    }
}
