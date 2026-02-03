<?php

namespace App\Filament\Resources\CompetitionWinners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CompetitionWinnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')
                    ->sortable(),
                TextColumn::make('competition.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->sortable(),
                IconColumn::make('no_competition')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('winner_name')
                    ->label('Winner')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
