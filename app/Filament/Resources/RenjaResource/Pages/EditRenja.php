<?php

namespace App\Filament\Resources\RenjaResource\Pages;

use App\Filament\Resources\RenjaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditRenja extends EditRecord
{
    protected static string $resource = RenjaResource::class;


    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updated_by'] = Auth::id();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
