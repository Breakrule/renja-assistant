<?php

namespace App\Actions\Renja;

use App\Models\Renja;
use App\Models\ContentBlock;
use Illuminate\Support\Carbon;
use App\Actions\Renja\Generators\BabIGenerator;

class GenerateRenjaDraftAction
{
    public function execute(Renja $renja): void
    {
        $renja->loadMissing('sections.subsections.contentBlock');

        if ($renja->sections->isEmpty()) {
            throw new \LogicException('Struktur Renja belum dibuat.');
        }

        foreach ($renja->sections as $section) {
            if (!$section || $section->subsections->isEmpty()) {
                continue;
            }

            foreach ($section->subsections as $sub) {
                $block = $sub->contentBlock;

                // ❌ Jangan timpa konten manual yang dikunci
                if ($block && $block->manual_locked) {
                    continue;
                }

                $content = $this->generateContentFor($renja, $sub); // fungsi Anda

                ContentBlock::updateOrCreate(
                    ['renja_subsection_id' => $sub->id],
                    [
                        'content' => $content,
                        'source' => 'generated',
                        'manual_locked' => false,
                        'last_generated_at' => Carbon::now(),
                    ]
                );
            }
        }
    }
    protected function generateContentFor(\App\Models\Renja $renja, \App\Models\RenjaSubsection $sub): string
    {
        return match ($sub->kode_subbab) {
            '1.1' => "Latar belakang penyusunan Renja {$renja->opd->nama_opd} Tahun {$renja->tahun} disusun berdasarkan RKPD dan RPJMD yang berlaku.",
            '1.2' => "Landasan hukum penyusunan Renja ini mengacu pada peraturan perundang-undangan yang berlaku.",
            default => "Konten draft awal untuk {$sub->judul}.",
        };
    }

}