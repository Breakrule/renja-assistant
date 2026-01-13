<?php

namespace App\Actions\Renja;

use App\Models\Renja;
use App\Models\RenjaSubsection;
use App\Models\ContentBlock;
use Illuminate\Support\Facades\Http;

class GenerateSubsectionWithAIAction
{
    public function execute(Renja $renja, RenjaSubsection $sub): void
    {
        // =========================
        // GUARDRAIL (WAJIB)
        // =========================
        if ($sub->status === 'final') {
            return;
        }

        $block = $sub->contentBlock;

        if ($block && $block->manual_locked) {
            return;
        }

        // =========================
        // PROMPT
        // =========================
        $prompt = $this->buildPrompt($renja, $sub);

        // =========================
        // CALL GROQ (OpenAI-compatible)
        // =========================
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.groq.key'),
            'Content-Type' => 'application/json',
        ])
            ->timeout(60)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => config('services.groq.model'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Anda adalah asisten perencanaan pembangunan daerah. Gunakan bahasa formal, netral, dan sesuai dokumen Renja Perangkat Daerah.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ],
                ],
                'temperature' => 0.3,
            ]);

        if (!$response->successful()) {
            // optional: log error
            return;
        }

        $content = trim(
            data_get($response->json(), 'choices.0.message.content', '')
        );

        if ($content === '') {
            return;
        }

        // =========================
        // SIMPAN HASIL
        // =========================
        ContentBlock::updateOrCreate(
            ['renja_subsection_id' => $sub->id],
            [
                'content' => $content,
                'source' => 'ai',
                'manual_locked' => false,
            ]
        );
    }

    protected function buildPrompt(Renja $renja, RenjaSubsection $sub): string
    {
        return <<<PROMPT
Tuliskan draf awal untuk sub-bab {$sub->kode_subbab} {$sub->judul}
dalam dokumen Rencana Kerja Perangkat Daerah (Renja).

Konteks:
- Perangkat Daerah: {$renja->opd->nama_opd}
- Tahun Renja: {$renja->tahun}

Ketentuan:
- Gunakan bahasa formal pemerintahan
- Fokus pada kebijakan dan arah perencanaan
- Jangan membuat data atau angka fiktif
- Jangan menyebut regulasi spesifik jika tidak pasti
- Panjang 2–4 paragraf
- Hasilkan teks naratif saja (tanpa heading)

PROMPT;
    }
}
