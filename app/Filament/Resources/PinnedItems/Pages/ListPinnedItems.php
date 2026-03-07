<?php

namespace App\Filament\Resources\PinnedItems\Pages;

use App\Filament\Resources\PinnedItems\PinnedItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPinnedItems extends ListRecords
{
    protected static string $resource = PinnedItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
