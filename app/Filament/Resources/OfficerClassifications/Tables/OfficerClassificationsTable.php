<?php

namespace App\Filament\Resources\OfficerClassifications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OfficerClassificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                ColorColumn::make('bg_color')
                    ->label('BG (Light)'),
                ColorColumn::make('text_color')
                    ->label('Text (Light)'),
                ColorColumn::make('bg_color_dark')
                    ->label('BG (Dark)'),
                ColorColumn::make('text_color_dark')
                    ->label('Text (Dark)'),
                TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
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
