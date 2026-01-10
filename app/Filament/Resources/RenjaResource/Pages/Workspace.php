<?php

namespace App\Filament\Resources\RenjaResource\Pages;

use Filament\Resources\Pages\Page;
use App\Filament\Resources\RenjaResource;
use App\Models\Renja;
use App\Actions\Renja\GenerateRenjaDraftAction;
use App\Actions\Renja\UpdateSubsectionStatusAction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\ContentBlock;
use Filament\Notifications\Notification;
use App\Actions\Renja\ExportRenjaDocxAction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class Workspace extends Page
{
    protected static string $resource = RenjaResource::class;

    protected static string $view = 'filament.resources.renja-resource.pages.workspace';

    public ?Renja $renja = null;
    public array $contents = [];


    /**
     * Manual handle {record}
     */
    public function mount(): void
    {
        $recordId = request()->route('record');

        if (!$recordId) {
            abort(404);
        }

        $this->renja = \App\Models\Renja::with([
            'opd',
            'sections.subsections.contentBlock',
        ])->findOrFail($recordId);

        // 🔐 Proteksi OPD
        if (
            auth()->user()->hasRole('opd') &&
            $this->renja->opd_id !== auth()->user()->opd_id
        ) {
            abort(403);
        }

        // 🔄 INISIALISASI STATE EDITOR
        $this->contents = [];

        foreach ($this->renja->sections as $section) {
            foreach ($section->subsections as $sub) {
                $this->contents[$sub->id] = $sub->contentBlock?->content ?? '';
            }
        }
    }


    public function generateDraft(): void
    {
        (new GenerateRenjaDraftAction())->execute($this->renja);

        Notification::make()->title('Berhasil')->body('Draft berhasil digenerate.')->success()->send();
    }

    public function updateStatus(int $subsectionId, string $status): void
    {
        $subsection = $this->renja
            ->sections
            ->flatMap->subsections
            ->firstWhere('id', $subsectionId);

        if (!$subsection) {
            return;
        }

        (new UpdateSubsectionStatusAction())
            ->execute($this->renja, $subsection, $status);

        Notification::make()->title('Berhasil')->body('Status diperbarui.')->success()->send();
    }

    public function canFinalize(): bool
    {
        return $this->renja->canBeFinal();
    }
    public function saveContent(int $subsectionId): void
    {
        $sub = $this->renja
            ->sections->flatMap->subsections
            ->firstWhere('id', $subsectionId);

        if (!$sub) {
            return;
        }

        ContentBlock::updateOrCreate(
            ['renja_subsection_id' => $sub->id],
            [
                'content' => $this->contents[$subsectionId] ?? '',
                'source' => 'manual',
            ]
        );

        Notification::make()
            ->title('Berhasil')
            ->body('Konten tersimpan.')
            ->success()
            ->send();
    }


    public function toggleLock(int $subsectionId): void
    {
        $block = ContentBlock::where('renja_subsection_id', $subsectionId)->first();
        if (!$block)
            return;

        $block->update([
            'manual_locked' => !$block->manual_locked,
        ]);

        Notification::make()->title('Berhasil')->body('Status lock diperbarui.')->success()->send();
    }
    public function finalizeRenja(): void
    {
        if (!$this->renja->canBeFinal()) {
            Notification::make()
                ->title('Gagal')
                ->body('Masih ada bagian yang belum final.')
                ->danger()
                ->send();
            return;
        }

        $this->renja->update([
            'status' => 'final',
        ]);

        Notification::make()
            ->title('Berhasil')
            ->body('Renja berhasil difinalisasi.')
            ->success()
            ->send();
    }
    public function exportDocx()
    {
        $relativePath = (new ExportRenjaDocxAction())
            ->execute($this->renja);

        $fullPath = storage_path('app/' . $relativePath);

        if (!file_exists($fullPath)) {
            Notification::make()
                ->title('Gagal')
                ->body('File tidak ditemukan.')
                ->danger()
                ->send();

            return;
        }

        return Response::download($fullPath);
    }

}
