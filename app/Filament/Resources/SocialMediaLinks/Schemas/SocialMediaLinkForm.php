<?php

namespace App\Filament\Resources\SocialMediaLinks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SocialMediaLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Link Details')
                    ->schema([
                        TextInput::make('platform')
                            ->placeholder('e.g. Facebook, Twitter, Instagram')
                            ->required(),
                        TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->required(),
                        TextInput::make('icon')
                            ->helperText('SVG path or class. We recommend using SVG for the best compatibility.')
                            ->required(),
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
