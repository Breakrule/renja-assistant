<?php

namespace App\Filament\Resources\RenjaResource\Pages;

use App\Filament\Resources\RenjaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Actions\Renja\GenerateRenjaStructureAction;
use Illuminate\Support\Facades\DB;



class CreateRenja extends CreateRecord
{
    protected static string $resource = RenjaResource::class;

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
}
