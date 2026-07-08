<?php

namespace App\Filament\Resources\MemberAnswers\Pages;

use App\Filament\Resources\MemberAnswers\MemberAnswerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMemberAnswer extends EditRecord
{
    protected static string $resource = MemberAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
