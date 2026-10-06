<?php

namespace App\Filament\Resources\HealthSafetyPages\Pages;

use App\Filament\Resources\HealthSafetyPages\HealthSafetyPageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHealthSafetyPages extends ListRecords
{
    protected static string $resource = HealthSafetyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
