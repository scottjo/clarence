<?php

namespace App\Filament\Resources\PinnedItems\Pages;

use App\Filament\Resources\PinnedItems\PinnedItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePinnedItem extends CreateRecord
{
    protected static string $resource = PinnedItemResource::class;
}
