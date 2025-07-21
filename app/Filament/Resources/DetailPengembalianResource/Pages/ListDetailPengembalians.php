<?php

namespace App\Filament\Resources\DetailPengembalianResource\Pages;

use App\Filament\Resources\DetailPengembalianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetailPengembalians extends ListRecords
{
    protected static string $resource = DetailPengembalianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
