<?php

namespace App\Filament\Resources\MemberAnswers\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class MemberAnswerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Answer')
                    ->schema([
                        Select::make('member_question_id')
                            ->label('Question')
                            ->relationship('question', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Hidden::make('user_id')
                            ->default(fn (): ?int => Auth::id())
                            ->visible(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?int $state): bool => filled($state)),
                        Select::make('user_id')
                            ->label('Answered by')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(fn (string $operation): bool => $operation === 'edit')
                            ->required(),
                        Textarea::make('body')
                            ->required()
                            ->maxLength(3000)
                            ->rows(8)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
