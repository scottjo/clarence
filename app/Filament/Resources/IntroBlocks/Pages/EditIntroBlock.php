<?php

namespace App\Filament\Resources\IntroBlocks\Pages;

use App\Filament\Resources\IntroBlocks\IntroBlockResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIntroBlock extends EditRecord
{
    protected static string $resource = IntroBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
