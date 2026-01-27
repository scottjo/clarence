<?php

namespace App\Filament\Resources\OfficerClassifications\Pages;

use App\Filament\Resources\OfficerClassifications\OfficerClassificationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOfficerClassification extends EditRecord
{
    protected static string $resource = OfficerClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
