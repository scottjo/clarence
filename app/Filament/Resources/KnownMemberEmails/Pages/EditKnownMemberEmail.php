<?php

namespace App\Filament\Resources\KnownMemberEmails\Pages;

use App\Filament\Resources\KnownMemberEmails\KnownMemberEmailResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKnownMemberEmail extends EditRecord
{
    protected static string $resource = KnownMemberEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
