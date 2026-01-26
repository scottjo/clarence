<?php

namespace App\Filament\Resources\Officers\Schemas;

use App\Enums\OfficerRole;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OfficerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('role')
                            ->options(OfficerRole::class)
                            ->required(),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])->columns(2),

                Section::make('Avatar')
                    ->schema([
                        FileUpload::make('avatar')
                            ->image()
                            ->directory('officers')
                            ->avatar()
                            ->imageEditor()
                            ->circleCropper(),
                    ]),
            ]);
    }
}
