<?php

namespace App\Filament\Resources\MemberQuestions\Pages;

use App\Filament\Resources\MemberQuestions\MemberQuestionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMemberQuestions extends ListRecords
{
    protected static string $resource = MemberQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
