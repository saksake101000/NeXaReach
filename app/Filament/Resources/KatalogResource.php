<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KatalogResource\Pages;
use App\Filament\Resources\KatalogResource\RelationManagers;
use App\Models\Katalog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KatalogResource extends Resource
{
    protected static ?string $model = Katalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('gambar')
                    ->image()
                    ->columnSpan(2)
                    ->directory('images')
                    ->required(),
                Forms\Components\Textarea::make('deskripsi')
                    ->required(),
                Forms\Components\TextInput::make('harga')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->sortable()->searchable(),
                Tables\Columns\ImageColumn::make('gambar')
                ->url(fn($record) => asset('storage/' . $record->gambar)) 
                    ->label('Gambar'),
                Tables\Columns\TextColumn::make('deskripsi')->limit(50),
                Tables\Columns\TextColumn::make('harga')->sortable(),
            ])
            ->filters([
                // You can add filters here if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKatalogs::route('/'),
            'create' => Pages\CreateKatalog::route('/create'),
            'edit' => Pages\EditKatalog::route('/{record}/edit'),
        ];
    }
}