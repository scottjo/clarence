<?php

namespace App\Filament\Resources\IntroBlocks\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Route;

class IntroBlockForm
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
                            ->helperText('Select the page where this introductory block should be displayed.'),
                        Toggle::make('is_active')
                            ->default(true),
                    ])
                    ->columnSpanFull(),

                Section::make('Content')
                    ->schema([
                        RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                        ColorPicker::make('font_color')
                            ->label('Font Colour')
                            ->helperText('Select a custom colour for the text. If left empty, the default will be used.'),
                    ])
                    ->columnSpanFull(),

                Section::make('Images')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('left_image')
                                    ->image()
                                    ->directory('intro-blocks')
                                    ->helperText('Optional image displayed on the left of the text.'),
                                FileUpload::make('right_image')
                                    ->image()
                                    ->directory('intro-blocks')
                                    ->helperText('Optional image displayed on the right of the text.'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
