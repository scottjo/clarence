<?php

namespace App\Filament\Resources\UsefulContacts\Pages;

use App\Filament\Resources\UsefulContacts\UsefulContactResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUsefulContacts extends ListRecords
{
    protected static string $resource = UsefulContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
