<?php

namespace App\Filament\Resources\UsefulContacts\Pages;

use App\Filament\Resources\UsefulContacts\UsefulContactResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUsefulContact extends CreateRecord
{
    protected static string $resource = UsefulContactResource::class;
}
