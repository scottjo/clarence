<?php

namespace App\Filament\Resources\Sponsors\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SponsorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Group::make([
                                    TextInput::make('name')
                                        ->required(),
                                    Textarea::make('address')
                                        ->rows(3),
                                    TextInput::make('phone')
                                        ->tel(),
                                    TextInput::make('website')
                                        ->url(),
                                ])->columnSpan(2),
                                SpatieMediaLibraryFileUpload::make('logo')
                                    ->collection('logo')
                                    ->multiple()
                                    ->maxFiles(1)
                                    ->image()
                                    ->responsiveImages()
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Visibility')
                    ->schema([
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Is active')
                            ->default(true),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
