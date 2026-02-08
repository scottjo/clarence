<?php

namespace App\Filament\Resources\Officers;

use App\Filament\Resources\Officers\Pages\CreateOfficer;
use App\Filament\Resources\Officers\Pages\EditOfficer;
use App\Filament\Resources\Officers\Pages\ListOfficers;
use App\Filament\Resources\Officers\Schemas\OfficerForm;
use App\Filament\Resources\Officers\Tables\OfficersTable;
use App\Models\Officer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OfficerResource extends Resource
{
    protected static ?string $model = Officer::class;

    protected static BackedEnum|null|string $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static null|string|UnitEnum $navigationGroup = 'Content';

    protected static ?int $navigationSort = 306;

    public static function form(Schema $schema): Schema
    {
        return OfficerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OfficersTable::configure($table);
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
            'index' => ListOfficers::route('/'),
            'create' => CreateOfficer::route('/create'),
            'edit' => EditOfficer::route('/{record}/edit'),
        ];
    }
}
