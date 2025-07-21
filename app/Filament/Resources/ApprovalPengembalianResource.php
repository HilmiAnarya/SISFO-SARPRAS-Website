<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovalPengembalianResource\Pages;
use App\Models\Pengembalian;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApprovalPengembalianResource extends Resource
{
    public static function getModel(): string
    {
        return Pengembalian::class;
    }

    public static function getNavigationLabel(): string
    {
        return 'Approval Pengembalian';
    }

    protected static ?string $navigationIcon = 'heroicon-o-arrow-uturn-down';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('peminjaman.user.name')->label('User'),
                Tables\Columns\TextColumn::make('tanggal_kembali')->date()->label('Tanggal Kembali'),
                Tables\Columns\TextColumn::make('catatan_user')->label('Catatan User')->wrap()->limit(50)->toggleable(),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'disetujui' => 'success',
                    'ditolak' => 'danger',
                }),
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
            'index' => Pages\ListApprovalPengembalians::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'pending');
    }
}
