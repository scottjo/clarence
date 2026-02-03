<?php

namespace App\Filament\Resources\CompetitionWinners\Pages;

use App\Filament\Resources\CompetitionWinners\CompetitionWinnerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompetitionWinners extends ListRecords
{
    protected static string $resource = CompetitionWinnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
