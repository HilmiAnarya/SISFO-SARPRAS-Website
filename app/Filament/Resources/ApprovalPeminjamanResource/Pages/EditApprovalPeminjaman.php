<?php

namespace App\Filament\Resources\ApprovalPeminjamanResource\Pages;

use App\Filament\Resources\ApprovalPeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovalPeminjaman extends EditRecord
{
    protected static string $resource = ApprovalPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
