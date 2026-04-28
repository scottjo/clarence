<?php

namespace App\Filament\Resources\Leagues\Pages;

use App\Filament\Resources\Leagues\LeagueResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateLeague extends CreateRecord
{
    protected static string $resource = LeagueResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }
}
