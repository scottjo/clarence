<?php

namespace App\Filament\Resources\HealthSafetyPages\Schemas;

use App\Models\HealthSafetyPage;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class HealthSafetyPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('subtitle')->maxLength(255),
                RichEditor::make('content')
                    ->label('Text')
                    ->fileAttachments(false)
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('title_image')
                    ->label('Image')
                    ->collection('title_image')
                    ->visibility('public')
                    ->image(),
                SpatieMediaLibraryFileUpload::make('attachments')
                    ->collection('attachments')
                    ->visibility('public')
                    ->multiple()
                    ->downloadable()
                    ->openable()
                    ->preserveFilenames()
                    ->maxSize(10240)
                    ->helperText('Attach PDFs, documents and other files (up to 10 MB each).')
                    ->columnSpanFull(),
                Toggle::make('is_active')->label('Active')->default(true),
                Placeholder::make('created_at')
                    ->label('Created at')
                    ->content(fn (?HealthSafetyPage $record): string => $record?->created_at?->format('j F Y, H:i') ?? 'Set automatically when this page is created.'),
            ]);
    }
}
