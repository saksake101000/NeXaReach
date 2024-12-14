<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Filament\Resources\TransaksiResource\Widgets\TransaksiOverview;
use App\Models\Transaksi;
use App\Models\Katalog;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Textarea;


class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('katalog_id')
                    ->label('Katalog Produk')
                    ->options(function () {
                        return Katalog::all()->pluck('nama', 'id')->toArray();  // Retrieve product catalog data
                    })
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->label('Pengguna')
                    ->options(function () {
                        return User::all()->pluck('name', 'id');  // Retrieve user data
                    })
                    ->required(),

                Forms\Components\TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->required()
                    ->numeric()
                    ->rules(['min:0']),

                Textarea::make('additional')
                    ->label('Additional Info')
                    ->nullable()
                    ->maxLength(500),

                Forms\Components\Select::make('status')
                    ->label('Status Transaksi')
                    ->options([
                        'belum bayar' => 'belum bayar',  // Yellow color for pending
                        'lunas' => 'lunas', // Green color for completed
                        'proses' => 'proses', // Green color for completed
                        'selesai' => 'selesai', // Green color for completed
                        'batal' => 'batal', // Red color for cancelled
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('katalog.nama')
                    ->label('Nama Produk')
                    ->sortable(),
    
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pengguna')
                    ->sortable(),
    
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->sortable(),
    
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Transaksi')
                    ->sortable()
                    ->color(function ($state) {
                        return match ($state) {
                            'belum bayar' => 'warning',  // Yellow color for pending
                            'lunas' => 'success', // Green color for completed
                            'proses' => 'success', // Green color for completed
                            'selesai' => 'success', // Green color for completed
                            'batal' => 'danger', // Red color for cancelled
                            default => 'secondary',  // Default gray color
                        };
                    }),
                
                Tables\Columns\TextColumn::make('additional')
                    ->label('Additional')
                    ->sortable(),
    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Transaksi')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            TransaksiOverview::class,
        ];
    }
}
