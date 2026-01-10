<?php

namespace App\Actions\Renja;

use App\Models\Renja;
use App\Models\ProgramAlignment;
use App\Domains\Planning\Rules\TujuanMustAlignWithRPJMD;

class ValidateAlignmentAction
{
    public function execute(Renja $renja): void
    {
        // bersihkan hasil lama
        ProgramAlignment::whereHas('program', function ($q) use ($renja) {
            $q->where('renja_id', $renja->id);
        })->delete();

        $rules = [
            new TujuanMustAlignWithRPJMD(),
            // nanti tambah rule lain di sini
        ];

        foreach ($rules as $rule) {
            $results = $rule->validate($renja);

            foreach ($results as $result) {
                ProgramAlignment::create([
                    'renja_program_id' => $result['program_id'],
                    'planning_goal_id' => $renja->programs
                        ->find($result['program_id'])
                        ->planning_goal_id,
                    'status' => $result['status'],
                    'catatan' => $result['catatan'],
                ]);
            }
        }
    }
}
