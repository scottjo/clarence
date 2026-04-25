<?php

namespace App\Filament\Resources\Newsletters\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NewsletterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('issue_date')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('newsletter_pdf')
                    ->label('Newsletter PDF')
                    ->collection('newsletter_pdf')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required()
                    ->preserveFilenames(),
                Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true)
                    ->required(),
            ]);
    }
}
