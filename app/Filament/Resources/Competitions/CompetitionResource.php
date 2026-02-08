<?php

namespace App\Filament\Resources\Competitions;

use App\Filament\Resources\Competitions\Pages\ManageCompetitions;
use App\Models\Competition;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class CompetitionResource extends Resource
{
    protected static ?string $model = Competition::class;

    protected static BackedEnum|null|string $navigationIcon = Heroicon::OutlinedTrophy;

    protected static null|string|UnitEnum $navigationGroup = 'Configuration';

    protected static ?int $navigationSort = 403;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('category')
                    ->options([
                        'Men' => 'Men',
                        'Ladies' => 'Ladies',
                        'Both' => 'Both',
                    ])
                    ->required(),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_important')
                    ->label('Is Overall Champion Competition?')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->sortable(),
                IconColumn::make('is_important')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCompetitions::route('/'),
        ];
    }
}
