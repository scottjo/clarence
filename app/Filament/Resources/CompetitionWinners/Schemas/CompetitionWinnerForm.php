<?php

namespace App\Filament\Resources\CompetitionWinners\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CompetitionWinnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->numeric()
                    ->required()
                    ->default(date('Y')),
                Select::make('competition_id')
                    ->relationship('competition', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live(),
                Select::make('category')
                    ->options([
                        'Men' => 'Men',
                        'Ladies' => 'Ladies',
                    ])
                    ->required()
                    ->default(fn (callable $get) => \App\Models\Competition::find($get('competition_id'))?->category === 'Both' ? null : \App\Models\Competition::find($get('competition_id'))?->category),
                Toggle::make('no_competition')
                    ->label('No Competition')
                    ->live(),
                TextInput::make('winner_name')
                    ->label('Winner Name')
                    ->required(fn (callable $get) => ! $get('no_competition'))
                    ->hidden(fn (callable $get) => $get('no_competition')),
            ]);
    }
}
