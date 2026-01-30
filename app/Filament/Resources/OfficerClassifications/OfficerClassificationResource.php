<?php

namespace App\Filament\Resources\OfficerClassifications;

use App\Filament\Resources\OfficerClassifications\Pages\CreateOfficerClassification;
use App\Filament\Resources\OfficerClassifications\Pages\EditOfficerClassification;
use App\Filament\Resources\OfficerClassifications\Pages\ListOfficerClassifications;
use App\Filament\Resources\OfficerClassifications\Schemas\OfficerClassificationForm;
use App\Filament\Resources\OfficerClassifications\Tables\OfficerClassificationsTable;
use App\Models\OfficerClassification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OfficerClassificationResource extends Resource
{
    protected static ?string $model = OfficerClassification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Configuration';

    public static function form(Schema $schema): Schema
    {
        return OfficerClassificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OfficerClassificationsTable::configure($table);
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
            'index' => ListOfficerClassifications::route('/'),
            'create' => CreateOfficerClassification::route('/create'),
            'edit' => EditOfficerClassification::route('/{record}/edit'),
        ];
    }
}
