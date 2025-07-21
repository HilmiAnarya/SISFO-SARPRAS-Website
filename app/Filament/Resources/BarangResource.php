<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\DateTimeColumn;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nama_barang')
                            ->required()
                            ->label('Nama Barang'),
                        Select::make('id_kategori')
                            ->label('Kategori')
                            ->relationship('kategori', 'nama_kategori')
                            ->searchable(false)
                            ->required(),
                        TextInput::make('stok')
                            ->numeric()
                            ->required()
                            ->label('stok'),
                        Select::make('kondisi')
                            ->label('Kondisi')
                            ->options([
                                'baik' => 'baik',
                                'rusak' => 'rusak',
                            ])
                            ->required(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')->label('Nama')->searchable()->sortable(),
                TextColumn::make('kategori.nama_kategori')->label('Kategori')->sortable(),
                TextColumn::make('stok')->label('stok')->sortable(),
                BadgeColumn::make('kondisi')
                    ->colors([
                        'success' => 'baik',
                        'danger' => 'rusak',
                    ])
                    ->label('Kondisi'),
            ])
            ->filters([
                // opsional: filter berdasarkan kondisi, kategori
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
