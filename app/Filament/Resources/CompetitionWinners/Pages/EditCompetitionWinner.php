<?php

namespace App\Filament\Resources\CompetitionWinners\Pages;

use App\Filament\Resources\CompetitionWinners\CompetitionWinnerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompetitionWinner extends EditRecord
{
    protected static string $resource = CompetitionWinnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
