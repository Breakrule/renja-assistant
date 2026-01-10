<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OpdResource\Pages;
use App\Filament\Resources\OpdResource\RelationManagers;
use App\Models\Opd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OpdResource extends Resource
{
    protected static ?string $model = Opd::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_opd')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('nama_opd')
                    ->required(),

                Forms\Components\TextInput::make('urusan')
                    ->required(),

                Forms\Components\TextInput::make('bidang')
                    ->required(),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_opd')->searchable(),
                Tables\Columns\TextColumn::make('nama_opd')->searchable(),
                Tables\Columns\TextColumn::make('urusan'),
                Tables\Columns\TextColumn::make('bidang'),
            ])
            ->defaultSort('kode_opd');
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
            'index' => Pages\ListOpds::route('/'),
            'create' => Pages\CreateOpd::route('/create'),
            'edit' => Pages\EditOpd::route('/{record}/edit'),
        ];
    }

}
