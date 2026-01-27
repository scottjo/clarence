<?php

namespace App\Filament\Resources\OfficerClassifications\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OfficerClassificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Classification Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),

                Section::make('Light Mode Colors')
                    ->schema([
                        ColorPicker::make('bg_color')
                            ->label('Background Color')
                            ->default('#ffffff')
                            ->required(),
                        ColorPicker::make('text_color')
                            ->label('Text Color')
                            ->default('#000000')
                            ->required(),
                    ])->columns(2),

                Section::make('Dark Mode Colors')
                    ->schema([
                        ColorPicker::make('bg_color_dark')
                            ->label('Background Color (Dark)')
                            ->default('#1f2937')
                            ->required(),
                        ColorPicker::make('text_color_dark')
                            ->label('Text Color (Dark)')
                            ->default('#ffffff')
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
