<?php

namespace App\Domains\Planning\Rules;

use App\Models\Renja;
use App\Models\PlanningGoal;

class TujuanMustAlignWithRPJMD implements RuleInterface
{
    public function validate(Renja $renja): array
    {
        $results = [];

        foreach ($renja->programs as $program) {

            if (!$program->planning_goal_id) {
                $results[] = [
                    'program_id' => $program->id,
                    'status' => 'mismatch',
                    'catatan' => 'Program tidak terhubung ke tujuan RPJMD'
                ];
                continue;
            }

            $goal = PlanningGoal::find($program->planning_goal_id);

            if ($goal->level !== 'tujuan' && $goal->level !== 'sasaran') {
                $results[] = [
                    'program_id' => $program->id,
                    'status' => 'warning',
                    'catatan' => 'Mapping ke level kebijakan terlalu umum'
                ];
            } else {
                $results[] = [
                    'program_id' => $program->id,
                    'status' => 'match',
                    'catatan' => null
                ];
            }
        }

        return $results;
    }
}
