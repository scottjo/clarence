<?php

namespace App\Filament\Resources\IntroBlocks\Pages;

use App\Filament\Resources\IntroBlocks\IntroBlockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIntroBlocks extends ListRecords
{
    protected static string $resource = IntroBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
