<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
//use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
//use Filament\Tables\Columns\DateTimeColumn;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Select::make('user_id')
                    ->label('Peminjam')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(),

                Select::make('barang_id')
                    ->label('Barang')
                    ->relationship('barang', 'nama_barang')
                    ->required()
                    ->searchable(),

                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->minValue(1)
                    ->required(),

                DatePicker::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->required(),

                DatePicker::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('pending')
                    ->required(),

            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Peminjam')->searchable(),
                TextColumn::make('barang.nama_barang')->label('Barang')->searchable(),
                TextColumn::make('jumlah')->label('Jumlah'),
                TextColumn::make('tanggal_pinjam')->label('Tgl Pinjam')->dateTime(),
                TextColumn::make('tanggal_kembali')->label('Tgl Kembali')->dateTime(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'disetujui',
                        'danger' => 'ditolak',
                    ]),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamen::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }
}
