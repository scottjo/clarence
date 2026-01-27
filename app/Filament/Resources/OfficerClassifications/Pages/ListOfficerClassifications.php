<?php

namespace App\Filament\Resources\OfficerClassifications\Pages;

use App\Filament\Resources\OfficerClassifications\OfficerClassificationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOfficerClassifications extends ListRecords
{
    protected static string $resource = OfficerClassificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
