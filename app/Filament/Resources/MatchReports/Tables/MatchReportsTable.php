<?php

namespace App\Filament\Resources\MatchReports\Tables;

use App\Models\MatchReport;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MatchReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('header_image')
                    ->collection('header_image'),
                TextColumn::make('team')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('opponent')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('year')
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('result')
                    ->state(fn (MatchReport $record): string => "{$record->our_score} - {$record->opponent_score}")
                    ->badge()
                    ->color(fn (MatchReport $record): string => $record->getResultBadgeColor()),
                TextColumn::make('author')
                    ->searchable(),
                TextColumn::make('is_published')
                    ->label('Published')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('team')
                    ->options(fn () => MatchReport::query()->distinct()->pluck('team', 'team')->toArray()),
                SelectFilter::make('year')
                    ->options(fn () => MatchReport::query()->distinct()->pluck('year', 'year')->toArray()),
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
