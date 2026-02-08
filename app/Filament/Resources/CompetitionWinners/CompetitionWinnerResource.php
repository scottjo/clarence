<?php

namespace App\Filament\Resources\CompetitionWinners;

use App\Filament\Resources\CompetitionWinners\Pages\CreateCompetitionWinner;
use App\Filament\Resources\CompetitionWinners\Pages\EditCompetitionWinner;
use App\Filament\Resources\CompetitionWinners\Pages\ListCompetitionWinners;
use App\Filament\Resources\CompetitionWinners\Schemas\CompetitionWinnerForm;
use App\Filament\Resources\CompetitionWinners\Tables\CompetitionWinnersTable;
use App\Models\CompetitionResult;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompetitionWinnerResource extends Resource
{
    protected static ?string $model = CompetitionResult::class;

    protected static ?string $slug = 'competition-winners';

    protected static ?string $modelLabel = 'Competition Winner';

    protected static BackedEnum|null|string $navigationIcon = Heroicon::OutlinedTrophy;

    protected static null|string|UnitEnum $navigationGroup = 'Content';

    protected static ?int $navigationSort = 305;

    public static function form(Schema $schema): Schema
    {
        return CompetitionWinnerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompetitionWinnersTable::configure($table);
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
            'index' => ListCompetitionWinners::route('/'),
            'create' => CreateCompetitionWinner::route('/create'),
            'edit' => EditCompetitionWinner::route('/{record}/edit'),
        ];
    }
}
