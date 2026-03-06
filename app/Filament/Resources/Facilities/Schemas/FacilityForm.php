<?php

namespace App\Filament\Resources\Facilities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('image_position')
                    ->options([
                        'left' => 'Left',
                        'right' => 'Right',
                        'above' => 'Above',
                        'below' => 'Below',
                    ])
                    ->required()
                    ->default('left'),
                Textarea::make('description')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image')
                    ->multiple()
                    ->maxFiles(1)
                    ->image()
                    ->responsiveImages()
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
