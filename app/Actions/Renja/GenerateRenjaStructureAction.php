<?php

namespace App\Actions\Renja;

use App\Models\Renja;

class GenerateRenjaStructureAction
{
    public function execute(Renja $renja): void
    {
        $template = [
            [
                'kode_bab' => 'I',
                'judul' => 'Pendahuluan',
                'subsections' => [
                    ['kode' => '1.1', 'judul' => 'Latar Belakang'],
                    ['kode' => '1.2', 'judul' => 'Landasan Hukum'],
                ],
            ],
            [
                'kode_bab' => 'II',
                'judul' => 'Gambaran Umum',
                'subsections' => [
                    ['kode' => '2.1', 'judul' => 'Kondisi Umum'],
                ],
            ],
        ];

        foreach ($template as $index => $bab) {
            $section = $renja->sections()->create([
                'kode_bab' => $bab['kode_bab'],
                'judul' => $bab['judul'],
                'urutan' => $index + 1, // 🔴 WAJIB
            ]);

            foreach ($bab['subsections'] as $sub) {
                $section->subsections()->create([
                    'kode_subbab' => $sub['kode'],
                    'judul' => $sub['judul'],
                    'tipe' => 'narrative',
                    'status' => 'draft',
                    // ❌ JANGAN ADA 'urutan'
                ]);
            }

        }
    }
}
