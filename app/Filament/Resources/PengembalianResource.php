<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengembalianResource\Pages;
use App\Models\Pengembalian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class PengembalianResource extends Resource
{
    protected static ?string $model = Pengembalian::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-uturn-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('id_peminjaman')
                        ->label('Peminjaman')
                        ->relationship('peminjaman', 'id_peminjaman')
                        ->searchable()
                        ->required(),

                    FileUpload::make('gambar_barang')
                        ->label('Gambar Barang')
                        ->image()
                        ->directory('pengembalian')
                        ->required(),

                    DatePicker::make('tanggal_kembali')
                        ->label('Tanggal Kembali')
                        ->required(),

                    Textarea::make('catatan_user')
                        ->label('Catatan User')
                        ->nullable(),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'pending' => 'Pending',
                            'disetujui' => 'Disetujui',
                            'ditolak' => 'Ditolak',
                        ])
                        ->required()
                        ->default('pending'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('peminjaman.id_peminjaman')->label('ID Peminjaman'),
                ImageColumn::make('gambar_barang')->label('Gambar')->disk('public')->height(80),
                TextColumn::make('tanggal_kembali')->label('Tanggal Kembali')->date(),
                TextColumn::make('status')->label('Status')->badge()->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'disetujui' => 'success',
                    'ditolak' => 'danger',
                }),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengembalians::route('/'),
            'create' => Pages\CreatePengembalian::route('/create'),
            'edit' => Pages\EditPengembalian::route('/{record}/edit'),
        ];
    }
}
