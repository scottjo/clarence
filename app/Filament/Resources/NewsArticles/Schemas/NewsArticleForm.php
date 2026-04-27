<?php

namespace App\Filament\Resources\NewsArticles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('title_image')
                    ->label('Title Image')
                    ->collection('title_image')
                    ->image()
                    ->responsiveImages(),
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->label('Gallery Images')
                    ->collection('gallery')
                    ->multiple()
                    ->image()
                    ->responsiveImages()
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('attachments')
                    ->collection('attachments')
                    ->multiple()
                    ->downloadable()
                    ->openable()
                    ->preserveFilenames()
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Is Active')
                    ->required(),
                Toggle::make('is_members_only')
                    ->label('Is Members Only')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
