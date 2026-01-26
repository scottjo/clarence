<?php

namespace App\Filament\Resources\SocialMediaLinks\Pages;

use App\Filament\Resources\SocialMediaLinks\SocialMediaLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSocialMediaLink extends EditRecord
{
    protected static string $resource = SocialMediaLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
