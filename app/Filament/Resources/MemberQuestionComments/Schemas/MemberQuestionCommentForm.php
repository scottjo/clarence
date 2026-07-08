<?php

namespace App\Filament\Resources\MemberQuestionComments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MemberQuestionCommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Comment')
                    ->schema([
                        Select::make('member_answer_id')
                            ->label('Answer')
                            ->relationship('answer', 'body')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Textarea::make('body')
                            ->required()
                            ->maxLength(1200)
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('Author')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Comment by')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('display_name')
                                    ->maxLength(255),
                                Toggle::make('is_anonymous')
                                    ->label('Anonymous')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
