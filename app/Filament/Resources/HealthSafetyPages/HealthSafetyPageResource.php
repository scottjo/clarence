<?php

namespace App\Filament\Resources\HealthSafetyPages;

use App\Filament\Resources\HealthSafetyPages\Pages\CreateHealthSafetyPage;
use App\Filament\Resources\HealthSafetyPages\Pages\EditHealthSafetyPage;
use App\Filament\Resources\HealthSafetyPages\Pages\ListHealthSafetyPages;
use App\Filament\Resources\HealthSafetyPages\Schemas\HealthSafetyPageForm;
use App\Filament\Resources\HealthSafetyPages\Tables\HealthSafetyPagesTable;
use App\Models\HealthSafetyPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class HealthSafetyPageResource extends Resource
{
    protected static ?string $model = HealthSafetyPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Club Health & Safety';

    protected static ?string $modelLabel = 'Health & Safety page';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return HealthSafetyPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HealthSafetyPagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHealthSafetyPages::route('/'),
            'create' => CreateHealthSafetyPage::route('/create'),
            'edit' => EditHealthSafetyPage::route('/{record}/edit'),
        ];
    }
}
