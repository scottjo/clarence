<?php

namespace App\Filament\Resources\MemberQuestionComments\Pages;

use App\Filament\Resources\MemberQuestionComments\MemberQuestionCommentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMemberQuestionComments extends ListRecords
{
    protected static string $resource = MemberQuestionCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
