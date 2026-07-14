<?php

namespace App\Filament\Resources\KnownMemberEmails;

use App\Filament\Resources\KnownMemberEmails\Pages\CreateKnownMemberEmail;
use App\Filament\Resources\KnownMemberEmails\Pages\EditKnownMemberEmail;
use App\Filament\Resources\KnownMemberEmails\Pages\ListKnownMemberEmails;
use App\Filament\Resources\KnownMemberEmails\Schemas\KnownMemberEmailForm;
use App\Filament\Resources\KnownMemberEmails\Tables\KnownMemberEmailsTable;
use App\Models\KnownMemberEmail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KnownMemberEmailResource extends Resource
{
    protected static ?string $model = KnownMemberEmail::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;

    protected static string|UnitEnum|null $navigationGroup = 'Members';

    protected static ?string $navigationLabel = 'Known Member Emails';

    protected static ?string $modelLabel = 'known member email';

    protected static ?string $pluralModelLabel = 'known member emails';

    protected static ?int $navigationSort = 104;

    public static function form(Schema $schema): Schema
    {
        return KnownMemberEmailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KnownMemberEmailsTable::configure($table);
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
            'index' => ListKnownMemberEmails::route('/'),
            'create' => CreateKnownMemberEmail::route('/create'),
            'edit' => EditKnownMemberEmail::route('/{record}/edit'),
        ];
    }
}
