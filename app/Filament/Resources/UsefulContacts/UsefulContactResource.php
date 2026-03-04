<?php

namespace App\Filament\Resources\UsefulContacts;

use App\Filament\Resources\UsefulContacts\Pages\CreateUsefulContact;
use App\Filament\Resources\UsefulContacts\Pages\EditUsefulContact;
use App\Filament\Resources\UsefulContacts\Pages\ListUsefulContacts;
use App\Filament\Resources\UsefulContacts\Schemas\UsefulContactForm;
use App\Filament\Resources\UsefulContacts\Tables\UsefulContactsTable;
use App\Models\UsefulContact;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UsefulContactResource extends Resource
{
    protected static ?string $model = UsefulContact::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhone;

    protected static null|string|\UnitEnum $navigationGroup = 'Content';

    protected static ?int $navigationSort = 410;

    public static function form(Schema $schema): Schema
    {
        return UsefulContactForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsefulContactsTable::configure($table);
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
            'index' => ListUsefulContacts::route('/'),
            'create' => CreateUsefulContact::route('/create'),
            'edit' => EditUsefulContact::route('/{record}/edit'),
        ];
    }
}
