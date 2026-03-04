<?php

namespace App\Filament\Resources\UsefulContacts\Pages;

use App\Filament\Resources\UsefulContacts\UsefulContactResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUsefulContact extends EditRecord
{
    protected static string $resource = UsefulContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
