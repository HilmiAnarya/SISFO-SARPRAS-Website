<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovalPeminjamanResource\Pages;
use App\Models\Peminjaman;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class  ApprovalPeminjamanResource extends Resource
{
    public static function getModel(): string
    {
        return Peminjaman::class;
    }

    public static function getNavigationLabel(): string
    {
        return 'Approval Peminjaman';
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Peminjam'),
                Tables\Columns\TextColumn::make('tanggal_pinjam')->label('Tanggal Pinjam')->date(),
                Tables\Columns\TextColumn::make('tanggal_kembali')->label('Tanggal Kembali')->date(),
                Tables\Columns\TextColumn::make('status')->label('Status'),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Setujui')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'disetujui'])),

                Action::make('reject')
                    ->label('Tolak')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'ditolak'])),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovalPeminjamen::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'pending');
    }
}
