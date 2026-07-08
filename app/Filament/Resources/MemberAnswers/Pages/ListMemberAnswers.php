<?php

namespace App\Filament\Resources\MemberAnswers\Pages;

use App\Filament\Resources\MemberAnswers\MemberAnswerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMemberAnswers extends ListRecords
{
    protected static string $resource = MemberAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
