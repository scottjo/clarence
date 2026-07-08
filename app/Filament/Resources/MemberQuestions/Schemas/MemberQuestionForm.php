<?php

namespace App\Filament\Resources\MemberQuestions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MemberQuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Question')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(160)
                            ->columnSpanFull(),
                        Textarea::make('body')
                            ->label('Details')
                            ->maxLength(3000)
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Author and moderation')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Submitted by')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('display_name')
                                    ->maxLength(255),
                                Toggle::make('is_anonymous')
                                    ->label('Anonymous')
                                    ->required(),
                                Toggle::make('is_locked')
                                    ->label('Locked')
                                    ->helperText('Locked questions cannot receive new answers or comments.')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
