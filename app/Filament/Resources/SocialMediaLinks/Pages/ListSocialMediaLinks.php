<?php

namespace App\Filament\Resources\SocialMediaLinks\Pages;

use App\Filament\Resources\SocialMediaLinks\SocialMediaLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSocialMediaLinks extends ListRecords
{
    protected static string $resource = SocialMediaLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
