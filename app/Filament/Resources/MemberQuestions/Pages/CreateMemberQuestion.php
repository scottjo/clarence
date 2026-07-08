<?php

namespace App\Filament\Resources\MemberQuestions\Pages;

use App\Filament\Resources\MemberQuestions\MemberQuestionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMemberQuestion extends CreateRecord
{
    protected static string $resource = MemberQuestionResource::class;
}
