<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RenjaResource\Pages;
use App\Filament\Resources\RenjaResource\RelationManagers;
use App\Models\Renja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Pages\RenjaWorkspace;
use Filament\Tables\Actions\Action;

class RenjaResource extends Resource
{
    protected static ?string $model = Renja::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Perencanaan';
    protected static ?string $label = 'Renja OPD';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // OPD UNTUK ADMIN
            Select::make('opd_id')
                ->relationship('opd', 'nama_opd')
                ->required()
                ->visible(fn() => auth()->user()->hasRole('admin')),

            // OPD UNTUK USER OPD (AUTO)
            Hidden::make('opd_id')
                ->default(fn() => auth()->user()->opd_id)
                ->visible(fn() => auth()->user()->hasRole('opd')),

            Forms\Components\TextInput::make('tahun')
                ->numeric()
                ->required(),

            Forms\Components\Hidden::make('versi')
                ->default(1),

            Forms\Components\Hidden::make('status')
                ->default('draft'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('opd.nama_opd')->label('OPD'),
                Tables\Columns\TextColumn::make('tahun'),
                Tables\Columns\BadgeColumn::make('status'),
            ])
            ->actions([
                Action::make('workspace')
                    ->label('Workspace')
                    ->icon('heroicon-o-folder-open')
                    ->url(
                        fn(Renja $record) =>
                        static::getUrl('workspace', ['record' => $record])
                    ),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRenjas::route('/'),
            'create' => Pages\CreateRenja::route('/create'),
            'edit' => Pages\EditRenja::route('/{record}/edit'),
            'workspace' => Pages\Workspace::route('/{record}/workspace'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->check()
            && auth()->user()->hasAnyRole(['admin', 'opd']);
    }
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->hasRole('opd')) {
            return $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
    public static function canDeleteAny(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

}
