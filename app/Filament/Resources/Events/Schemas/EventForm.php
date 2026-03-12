<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                DateTimePicker::make('start_time')
                    ->required(),
                DateTimePicker::make('end_time'),
                TextInput::make('location')
                    ->maxLength(255),
                SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image')
                    ->image()
                    ->responsiveImages(),
                Section::make('Overlay Message')
                    ->description('Display a "sticky note" message over the event image.')
                    ->schema([
                        Toggle::make('overlay_active')
                            ->label('Enable Overlay Message')
                            ->default(true)
                            ->live(),
                        TextInput::make('overlay_label')
                            ->label('Label (for list view)')
                            ->placeholder('e.g. POSTPONED')
                            ->maxLength(255)
                            ->visible(fn ($get) => $get('overlay_active')),
                        Textarea::make('overlay_message')
                            ->label('Full Message (for details view)')
                            ->placeholder('e.g. Unfortunately, this event has been postponed...')
                            ->rows(3)
                            ->visible(fn ($get) => $get('overlay_active')),
                    ])->columns(1),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
