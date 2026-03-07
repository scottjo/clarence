<?php

namespace App\Filament\Resources\PinnedItems\Pages;

use App\Filament\Resources\PinnedItems\PinnedItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPinnedItem extends EditRecord
{
    protected static string $resource = PinnedItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
