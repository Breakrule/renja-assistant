<?php

namespace App\Actions\Renja;

use App\Models\Renja;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ExportRenjaDocxAction
{

    public function execute(Renja $renja): string
    {
        $renja->loadMissing([
            'opd',
            'sections.subsections.contentBlock',
        ]);

        $phpWord = new PhpWord();

        // ==== STYLE DASAR ====
        $phpWord->addTitleStyle(1, ['bold' => true, 'size' => 14]);
        $phpWord->addTitleStyle(2, ['bold' => true, 'size' => 12]);

        $section = $phpWord->addSection();

        // ==== COVER SEDERHANA ====
        $section->addText(
            'RENCANA KERJA PERANGKAT DAERAH',
            ['bold' => true, 'size' => 16],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);

        $section->addText(
            strtoupper($renja->opd->nama_opd),
            ['bold' => true],
            ['alignment' => 'center']
        );

        $section->addText(
            'TAHUN ' . $renja->tahun,
            [],
            ['alignment' => 'center']
        );

        $section->addPageBreak();

        // ==== ISI DOKUMEN ====
        foreach ($renja->sections as $bab) {
            $section->addTitle(
                'BAB ' . $bab->kode_bab . ' ' . strtoupper($bab->judul),
                1
            );

            foreach ($bab->subsections as $sub) {
                $section->addTitle(
                    $sub->kode_subbab . ' ' . $sub->judul,
                    2
                );

                $content = $sub->contentBlock?->content
                    ?? '[BELUM ADA KONTEN]';

                $section->addText($content, [], ['spaceAfter' => 200]);
            }
        }

        // ==== SIMPAN FILE ====
        $exportDir = storage_path('app/exports');

        if (!File::exists($exportDir)) {
            File::makeDirectory($exportDir, 0755, true);
        }
        $fileName = 'Renja_' . str_replace(' ', '_', $renja->opd->nama_opd) . '_' . $renja->tahun . '.docx';
        $fullPath = $exportDir . DIRECTORY_SEPARATOR . $fileName;

        IOFactory::createWriter($phpWord, 'Word2007')->save($fullPath);

        return 'exports/' . $fileName;
    }
}
