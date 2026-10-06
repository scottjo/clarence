<?php

namespace App\Filament\Resources\HealthSafetyPages\Pages;

use App\Filament\Resources\HealthSafetyPages\HealthSafetyPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHealthSafetyPage extends EditRecord
{
    protected static string $resource = HealthSafetyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
