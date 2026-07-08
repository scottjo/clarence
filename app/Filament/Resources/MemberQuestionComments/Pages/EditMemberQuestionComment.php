<?php

namespace App\Filament\Resources\MemberQuestionComments\Pages;

use App\Filament\Resources\MemberQuestionComments\MemberQuestionCommentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMemberQuestionComment extends EditRecord
{
    protected static string $resource = MemberQuestionCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
