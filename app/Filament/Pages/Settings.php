<?php

namespace App\Filament\Pages;

use App\Enums\GradientDirection;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::first();

        if ($settings) {
            $this->form->fill($settings->toArray());
        }
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Club Information')
                    ->schema([
                        TextInput::make('club_name')
                            ->required(),
                        Textarea::make('address')
                            ->rows(3),
                        TextInput::make('phone')
                            ->tel(),
                        TextInput::make('email')
                            ->email(),
                        TextInput::make('member_login_url')
                            ->label('Member Login URL')
                            ->url()
                            ->helperText('The URL for the Member Login button in the menu bar.'),
                    ])->columns(2),

                Section::make('Map Location')
                    ->schema([
                        TextInput::make('latitude')
                            ->numeric()
                            ->step(0.00000001),
                        TextInput::make('longitude')
                            ->numeric()
                            ->step(0.00000001),
                    ])->columns(2),

                Section::make('Header Appearance')
                    ->schema([
                        FileUpload::make('header_logo')
                            ->image()
                            ->directory('logos')
                            ->helperText('The logo displayed in the top navigation bar.'),
                        ColorPicker::make('menu_color')
                            ->label('Background Color')
                            ->helperText('Used if no gradient is set.'),
                        ColorPicker::make('menu_text_color')
                            ->label('Text Color'),
                        ColorPicker::make('header_gradient_start')
                            ->label('Gradient Start'),
                        ColorPicker::make('header_gradient_end')
                            ->label('Gradient End'),
                        Select::make('header_gradient_direction')
                            ->label('Gradient Direction')
                            ->options(GradientDirection::class)
                            ->default(GradientDirection::LeftToRight),
                    ])->columns(3),

                Section::make('Footer Appearance')
                    ->schema([
                        FileUpload::make('footer_logo_left')
                            ->image()
                            ->directory('logos')
                            ->helperText('Optional logo for the left side of the footer.'),
                        FileUpload::make('footer_logo_right')
                            ->image()
                            ->directory('logos')
                            ->helperText('Optional logo for the right side of the footer.'),
                        ColorPicker::make('footer_color')
                            ->label('Background Color')
                            ->helperText('Used if no gradient is set.'),
                        ColorPicker::make('footer_text_color')
                            ->label('Text Color'),
                        ColorPicker::make('footer_gradient_start')
                            ->label('Gradient Start'),
                        ColorPicker::make('footer_gradient_end')
                            ->label('Gradient End'),
                        Select::make('footer_gradient_direction')
                            ->label('Gradient Direction')
                            ->options(GradientDirection::class)
                            ->default(GradientDirection::LeftToRight),
                    ])->columns(3),

                Section::make('General Appearance')
                    ->schema([
                        ColorPicker::make('page_bg_color')
                            ->label('Page Background Color'),
                        ColorPicker::make('page_bg_color_dark')
                            ->label('Page Background Color (Dark Mode)'),
                    ])->columns(2),

                Section::make('Pinstripe Appearance')
                    ->schema([
                        ColorPicker::make('pinstripe_color')
                            ->label('Color'),
                        Select::make('pinstripe_width')
                            ->label('Width')
                            ->options([
                                'thin' => 'Thin',
                                'medium' => 'Medium',
                                'thick' => 'Thick',
                            ])
                            ->default('medium'),
                        Select::make('pinstripe_style')
                            ->label('Style')
                            ->options([
                                'single' => 'Single Line',
                                'double' => 'Two Thin Lines',
                            ])
                            ->default('single'),
                    ])->columns(3),

                Section::make('Sponsor Panel Appearance')
                    ->schema([
                        ColorPicker::make('sponsor_panel_bg_color')
                            ->label('Background Color'),
                        ColorPicker::make('sponsor_panel_bg_color_dark')
                            ->label('Background Color (Dark Mode)'),
                        ColorPicker::make('sponsor_panel_pinstripe_color')
                            ->label('Border Color'),
                        Select::make('sponsor_panel_pinstripe_width')
                            ->label('Border Width')
                            ->options([
                                'thin' => 'Thin',
                                'medium' => 'Medium',
                                'thick' => 'Thick',
                            ])
                            ->default('medium'),
                        Select::make('sponsor_panel_pinstripe_style')
                            ->label('Border Style')
                            ->options([
                                'single' => 'Single Line',
                                'double' => 'Two Thin Lines',
                            ])
                            ->default('single'),
                    ])->columns(3),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::updateOrCreate([], $data);

        Notification::make()
            ->title('Settings saved successfully.')
            ->success()
            ->send();
    }
}
