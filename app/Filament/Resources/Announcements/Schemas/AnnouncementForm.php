<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Announcement Details')
                    ->schema([
                        TextInput::make('header')
                            ->required()
                            ->live()
                            ->maxLength(255),
                        Textarea::make('text')
                            ->required()
                            ->live()
                            ->rows(3),
                        Select::make('type')
                            ->options([
                                'info' => 'Info (Blue)',
                                'success' => 'Success (Green)',
                                'warning' => 'Warning (Yellow)',
                                'danger' => 'Danger (Red)',
                            ])
                            ->required()
                            ->live()
                            ->default('info'),
                        Toggle::make('is_active')
                            ->label('Show Announcement')
                            ->default(false),
                        DateTimePicker::make('starts_at')
                            ->label('Show From'),
                        DateTimePicker::make('ends_at')
                            ->label('Show Until'),
                    ])->columns(2)
                    ->columnSpanFull(),

                Section::make('Preview')
                    ->schema([
                        Placeholder::make('preview')
                            ->label('')
                            ->content(function (Get $get) {
                                $header = $get('header');
                                $text = $get('text');
                                $type = $get('type') ?? 'info';

                                if (! $header && ! $text) {
                                    return new HtmlString('<div class="text-gray-500 italic">Enter a header or text to see a preview.</div>');
                                }

                                $colors = [
                                    'info' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'success' => 'bg-green-100 text-green-800 border-green-200',
                                    'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'danger' => 'bg-red-100 text-red-800 border-red-200',
                                ];

                                $colorClass = $colors[$type] ?? $colors['info'];

                                $headerHtml = e($header);
                                $textHtml = nl2br(e($text));

                                return new HtmlString("
                                    <div class=\"rounded-lg border shadow-sm p-4 {$colorClass}\" role=\"alert\">
                                        <p class=\"font-bold text-lg leading-none\">{$headerHtml}</p>
                                        <p class=\"mt-1 font-medium\">{$textHtml}</p>
                                    </div>
                                ");
                            }),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
