<?php

namespace App\Filament\Resources\Fixtures\Schemas;

use App\Enums\FixtureType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FixtureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options(FixtureType::class)
                    ->required(),
                TextInput::make('opponent')
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('date')
                    ->required(),
                Select::make('venue')
                    ->options([
                        'Home' => 'Home',
                        'Away' => 'Away',
                    ])
                    ->required(),
                TextInput::make('competition')
                    ->maxLength(255),
                Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
