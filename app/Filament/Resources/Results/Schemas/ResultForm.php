<?php

namespace App\Filament\Resources\Results\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ResultForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('fixture_id')
                    ->relationship('fixture', 'opponent')
                    ->required(),
                TextInput::make('home_score')
                    ->numeric()
                    ->required(),
                TextInput::make('away_score')
                    ->numeric()
                    ->required(),
                Textarea::make('summary')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
