<?php

namespace App\Actions\Renja\Generators;

use App\Models\Renja;

class BabIGenerator
{
    public function generate(Renja $renja): array
    {
        return [
            '1.1' => $this->latarBelakang($renja),
            '1.2' => $this->landasanHukum(),
            '1.3' => $this->maksudTujuan(),
            '1.4' => $this->sistematika(),
        ];
    }

    protected function latarBelakang(Renja $renja): string
    {
        return <<<TEXT
Renja {$renja->opd->nama_opd} Tahun {$renja->tahun} disusun sebagai
pedoman pelaksanaan program dan kegiatan OPD yang selaras dengan
RPJMD dan RKPD tahun berjalan.
TEXT;
    }

    protected function landasanHukum(): string
    {
        return <<<'TEXT'
Penyusunan Renja OPD berlandaskan pada ketentuan peraturan perundang-undangan
yang berlaku, baik di tingkat nasional maupun daerah.
TEXT;
    }

    protected function maksudTujuan(): string
    {
        return <<<'TEXT'
Maksud penyusunan Renja ini adalah sebagai acuan pelaksanaan kegiatan OPD,
sedangkan tujuannya untuk menjamin keterpaduan perencanaan pembangunan daerah.
TEXT;
    }

    protected function sistematika(): string
    {
        return <<<'TEXT'
Dokumen Renja OPD ini disusun dengan sistematika yang terdiri dari lima bab,
mulai dari pendahuluan hingga penutup.
TEXT;
    }
}
