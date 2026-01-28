<?php

namespace App\Filament\Resources\SocialMediaLinks\Schemas;

use App\Enums\SocialPlatform;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SocialMediaLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Link Details')
                    ->schema([
                        Select::make('platform')
                            ->options(SocialPlatform::class)
                            ->live()
                            ->afterStateUpdated(fn (SocialPlatform $state, Set $set) => $set('icon', $state->getIcon()))
                            ->required(),
                        TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->required(),
                        Select::make('icon')
                            ->options(collect(SocialPlatform::cases())->mapWithKeys(fn ($platform) => [$platform->getIcon() => $platform->getLabel()]))
                            ->allowHtml()
                            ->required(),
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->required(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
