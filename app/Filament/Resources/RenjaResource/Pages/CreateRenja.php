<?php

namespace App\Filament\Resources\RenjaResource\Pages;

use App\Filament\Resources\RenjaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Actions\Renja\GenerateRenjaStructureAction;
use Illuminate\Support\Facades\DB;
use App\Actions\Renja\CreateRenjaAction;
use Illuminate\Database\Eloquent\Model;


class CreateRenja extends CreateRecord
{
    protected static string $resource = RenjaResource::class;
    protected function handleRecordCreation(array $data): Model
    {
        return (new CreateRenjaAction)->execute(
            tahun: (int) $data['tahun'],
            opdId: (int) $data['opd_id'],
            createdBy: auth()->id(),
            status: 'draft'
        );
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        if ($user->hasRole('opd')) {
            $data['opd_id'] = $user->opd_id;
        }

        $data['created_by'] = $user->id;
        $data['status'] = 'draft';

        return $data;
    }
    protected function afterCreate(): void
    {
        DB::transaction(function () {
            (new GenerateRenjaStructureAction())
                ->execute($this->record);
        });
    }
    /**
     * 🔑 INI KUNCINYA
     * Redirect ke halaman list (index), bukan edit
     */
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
