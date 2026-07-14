<?php

namespace App\Filament\Resources\KnownMemberEmails\Pages;

use App\Filament\Resources\KnownMemberEmails\KnownMemberEmailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKnownMemberEmails extends ListRecords
{
    protected static string $resource = KnownMemberEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
