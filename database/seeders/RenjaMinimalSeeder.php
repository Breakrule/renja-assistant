<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Opd;
use App\Models\Renja;
use App\Models\RenjaSection;
use App\Models\RenjaSubsection;

class RenjaMinimalSeeder extends Seeder
{
    public function run(): void
    {
        $opd = Opd::first() ?? Opd::create([
            'kode_opd' => '1.01.01',
            'nama_opd' => 'Dinas Contoh',
            'urusan' => 'Perekonomian',
            'bidang' => 'Perencanaan',
        ]);

        $renja = Renja::create([
            'opd_id' => $opd->id,
            'tahun' => now()->year,
            'versi' => 1,
            'status' => 'draft',
            'created_by' => 1,
        ]);

        $babI = RenjaSection::create([
            'renja_id' => $renja->id,
            'kode_bab' => 'I',
            'judul' => 'Pendahuluan',
            'urutan' => 1,
        ]);

        RenjaSubsection::insert([
            [
                'renja_section_id' => $babI->id,
                'kode_subbab' => '1.1',
                'judul' => 'Latar Belakang',
                'tipe' => 'narrative',
            ],
            [
                'renja_section_id' => $babI->id,
                'kode_subbab' => '1.2',
                'judul' => 'Landasan Hukum',
                'tipe' => 'narrative',
            ],
            [
                'renja_section_id' => $babI->id,
                'kode_subbab' => '1.3',
                'judul' => 'Maksud dan Tujuan',
                'tipe' => 'narrative',
            ],
            [
                'renja_section_id' => $babI->id,
                'kode_subbab' => '1.4',
                'judul' => 'Sistematika Penulisan',
                'tipe' => 'narrative',
            ],
        ]);
    }
}
