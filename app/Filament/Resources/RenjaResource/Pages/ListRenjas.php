<?php

namespace App\Filament\Resources\RenjaResource\Pages;

use App\Filament\Resources\RenjaResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;

class ListRenjas extends ListRecords
{
    protected static string $resource = RenjaResource::class;

    protected function getTableActions(): array
    {
        return [
            Action::make('workspace')
                ->label('Workspace')
                ->icon('heroicon-o-folder-open')
                ->url(
                    fn($record) =>
                    RenjaResource::getUrl('workspace', ['record' => $record])
                ),
        ];
    }

    protected function getTableRecordUrlUsing(): ?\Closure
    {
        return null; // tetap matikan klik baris
    }
}
