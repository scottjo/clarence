<?php

namespace App\Filament\Resources\MembershipLevels;

use App\Filament\Resources\MembershipLevels\Pages\ManageMembershipLevels;
use App\Filament\Resources\MembershipLevels\Schemas\MembershipLevelForm;
use App\Filament\Resources\MembershipLevels\Tables\MembershipLevelsTable;
use App\Models\MembershipLevel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MembershipLevelResource extends Resource
{
    protected static ?string $model = MembershipLevel::class;

    protected static BackedEnum|null|string $navigationIcon = Heroicon::OutlinedTicket;

    protected static null|string|UnitEnum $navigationGroup = 'Configuration';

    protected static ?int $navigationSort = 407;

    public static function form(Schema $schema): Schema
    {
        return MembershipLevelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MembershipLevelsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMembershipLevels::route('/'),
        ];
    }
}
