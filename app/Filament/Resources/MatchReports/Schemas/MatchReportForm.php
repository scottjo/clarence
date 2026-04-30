<?php

namespace App\Filament\Resources\MatchReports\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class MatchReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Match Details')
                    ->schema([
                        TextInput::make('team')
                            ->required()
                            ->placeholder('e.g. Clarence A')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, Get $get) => static::updateTitle($set, $get)),
                        TextInput::make('opponent')
                            ->required()
                            ->placeholder('e.g. Bellerive')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, Get $get) => static::updateTitle($set, $get)),
                        TextInput::make('year')
                            ->numeric()
                            ->default(now()->year)
                            ->required(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Score & Title')
                    ->schema([
                        TextInput::make('our_score')
                            ->label('Our Score')
                            ->numeric()
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, Get $get) => static::updateTitle($set, $get)),
                        TextInput::make('opponent_score')
                            ->label('Opponent Score')
                            ->numeric()
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, Get $get) => static::updateTitle($set, $get)),
                        TextInput::make('title')
                            ->required()
                            ->placeholder('Generated automatically: Team X-Y Opponent')
                            ->helperText('The title consists of our team, our score vs their score and their team name.'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Content')
                    ->schema([
                        RichEditor::make('description')
                            ->required()
                            ->columnSpanFull()
                            ->extraInputAttributes(['style' => 'min-height: 400px;']),
                        Textarea::make('rink_scores')
                            ->rows(5)
                            ->helperText('Detail of the rink scores.')
                            ->columnSpanFull(),
                        TextInput::make('author')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Media')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('header_image')
                            ->collection('header_image')
                            ->image()
                            ->responsiveImages(),
                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->collection('gallery')
                            ->multiple()
                            ->image()
                            ->responsiveImages()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->default(true),
            ]);
    }

    protected static function updateTitle(Set $set, Get $get): void
    {
        $team = $get('team') ?? '';
        $opponent = $get('opponent') ?? '';
        $ourScore = $get('our_score');
        $oppScore = $get('opponent_score');

        if ($team && $opponent && $ourScore !== null && $oppScore !== null) {
            $set('title', "{$team} {$ourScore}-{$oppScore} {$opponent}");
        }
    }
}
