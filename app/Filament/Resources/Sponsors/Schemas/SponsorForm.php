<?php

namespace App\Filament\Resources\Sponsors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Route;

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
                                FileUpload::make('logo')
                                    ->image()
                                    ->directory('sponsors')
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Visibility')
                    ->schema([
                        Toggle::make('show_on_all_pages')
                            ->label('Show on all pages')
                            ->default(true)
                            ->live(),
                        Select::make('pages')
                            ->multiple()
                            ->options(function () {
                                $routes = Route::getRoutes()->getRoutesByName();
                                $options = [];
                                foreach ($routes as $name => $route) {
                                    if (in_array('GET', $route->methods()) && ! str_starts_with($name, 'filament.') && ! str_starts_with($name, 'horizon.') && ! str_starts_with($name, 'livewire.')) {
                                        $options[$name] = $name.' ('.$route->uri().')';
                                    }
                                }
                                asort($options);

                                return $options;
                            })
                            ->visible(fn (Get $get) => ! $get('show_on_all_pages'))
                            ->searchable(),
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
