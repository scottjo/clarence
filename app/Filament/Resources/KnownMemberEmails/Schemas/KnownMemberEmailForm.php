<?php

namespace App\Filament\Resources\KnownMemberEmails\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KnownMemberEmailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('name')
                    ->maxLength(255),
            ]);
    }
}
