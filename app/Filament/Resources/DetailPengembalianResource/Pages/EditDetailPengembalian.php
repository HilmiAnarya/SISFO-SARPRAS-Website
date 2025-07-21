<?php

namespace App\Filament\Resources\DetailPengembalianResource\Pages;

use App\Filament\Resources\DetailPengembalianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetailPengembalian extends EditRecord
{
    protected static string $resource = DetailPengembalianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
