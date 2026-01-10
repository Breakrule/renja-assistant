<?php

namespace App\Filament\Resources\RenjaResource\Pages;

use App\Filament\Resources\RenjaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use App\Models\Renja;

class ListRenjas extends ListRecords
{
    protected static string $resource = RenjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
