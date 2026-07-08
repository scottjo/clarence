<?php

namespace App\Filament\Resources\MemberQuestions\Pages;

use App\Filament\Resources\MemberQuestions\MemberQuestionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMemberQuestion extends EditRecord
{
    protected static string $resource = MemberQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
