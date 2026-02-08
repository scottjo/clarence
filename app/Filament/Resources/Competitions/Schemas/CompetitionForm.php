<?php

namespace App\Filament\Resources\Competitions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CompetitionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('category')
                    ->options([
                        'Men' => 'Men',
                        'Ladies' => 'Ladies',
                        'Both' => 'Both',
                    ])
                    ->required(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_important')
                    ->label('Is Overall Champion Competition?')
                    ->default(false),
            ]);
    }
}
