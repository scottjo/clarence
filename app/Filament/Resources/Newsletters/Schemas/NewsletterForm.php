<?php

namespace App\Filament\Resources\Newsletters\Schemas;

use App\Models\Newsletter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
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
                Select::make('type')
                    ->options(Newsletter::typeOptions())
                    ->default(Newsletter::TYPE_NEWSLETTER)
                    ->required(),
                DatePicker::make('issue_date')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('newsletter_pdf')
                    ->label('Document PDF')
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
