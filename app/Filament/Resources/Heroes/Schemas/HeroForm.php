<?php

namespace App\Filament\Resources\Heroes\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Route;

class HeroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Page Configuration')
                    ->schema([
                        Select::make('page_identifier')
                            ->label('Page')
                            ->options(function () {
                                $routes = Route::getRoutes();
                                $options = [];
                                foreach ($routes as $route) {
                                    if ($route->getName() && ! str_starts_with($route->getName(), 'filament.') && ! str_starts_with($route->getName(), 'livewire.')) {
                                        $options[$route->getName()] = $route->getName().' ('.$route->uri().')';
                                    }
                                }
                                asort($options);

                                return $options;
                            })
                            ->required()
                            ->searchable()
                            ->helperText('Select the page where this hero section should be displayed.'),
                    ])
                    ->columnSpanFull(),

                Section::make('Content')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->directory('heroes')
                                    ->required(),
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('title')
                                            ->maxLength(255),
                                        TextInput::make('subtitle')
                                            ->maxLength(255),
                                        Textarea::make('intro_text')
                                            ->rows(3),
                                    ])
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Styling')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                ColorPicker::make('title_color')
                                    ->default('#ffffff'),
                                Select::make('title_size')
                                    ->options([
                                        'text-4xl md:text-6xl' => 'Medium',
                                        'text-5xl md:text-7xl' => 'Large',
                                        'text-6xl md:text-8xl' => 'Extra Large',
                                    ])
                                    ->default('text-5xl md:text-7xl'),
                                ColorPicker::make('subtitle_color')
                                    ->default('#ffffff'),
                                Select::make('subtitle_size')
                                    ->options([
                                        'text-lg md:text-xl' => 'Small',
                                        'text-xl md:text-2xl' => 'Medium',
                                        'text-2xl md:text-3xl' => 'Large',
                                    ])
                                    ->default('text-xl md:text-2xl'),
                                ColorPicker::make('intro_color')
                                    ->default('#ffffff'),
                                Select::make('intro_size')
                                    ->options([
                                        'text-sm' => 'Small',
                                        'text-base' => 'Base',
                                        'text-lg' => 'Large',
                                        'text-xl' => 'Extra Large',
                                    ])
                                    ->default('text-lg'),
                                Select::make('font_family')
                                    ->options([
                                        'font-sans' => 'Sans-serif',
                                        'font-serif' => 'Serif',
                                        'font-mono' => 'Monospace',
                                    ])
                                    ->default('font-sans'),
                                Select::make('overlay_opacity')
                                    ->options([
                                        0 => 'None',
                                        10 => '10%',
                                        20 => '20%',
                                        30 => '30%',
                                        40 => '40%',
                                        50 => '50%',
                                        60 => '60%',
                                        70 => '70%',
                                        80 => '80%',
                                        90 => '90%',
                                    ])
                                    ->default(50),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
