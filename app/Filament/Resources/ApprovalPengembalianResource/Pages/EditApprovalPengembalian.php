<?php

namespace App\Filament\Resources\ApprovalPengembalianResource\Pages;

use App\Filament\Resources\ApprovalPengembalianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovalPengembalian extends EditRecord
{
    protected static string $resource = ApprovalPengembalianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
