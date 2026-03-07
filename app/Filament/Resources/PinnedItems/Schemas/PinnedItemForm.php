<?php

namespace App\Filament\Resources\PinnedItems\Schemas;

use App\Models\NewsArticle;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PinnedItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('news_article_id')
                    ->label('Link to News Article')
                    ->options(fn () => NewsArticle::query()->where('is_active', true)->pluck('title', 'id'))
                    ->searchable()
                    ->placeholder('Select a news article to link to (optional)'),
                SpatieMediaLibraryFileUpload::make('image')
                    ->label('Image or PDF')
                    ->collection('image')
                    ->multiple()
                    ->maxFiles(1)
                    ->responsiveImages()
                    ->helperText('Upload an image or PDF to be displayed on the pinned notice.'),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->required(),
                Radio::make('position')
                    ->options([
                        'left' => 'Left',
                        'right' => 'Right',
                    ])
                    ->default('right')
                    ->required()
                    ->inline(),
            ]);
    }
}
