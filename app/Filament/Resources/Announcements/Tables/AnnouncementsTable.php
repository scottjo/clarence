<?php

namespace App\Filament\Resources\Announcements\Tables;

use App\Filament\Columns\StyledToggleColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnnouncementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('header')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'info' => 'info',
                        'success' => 'success',
                        'warning' => 'warning',
                        'danger' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                StyledToggleColumn::create('is_active')
                    ->label('Active')
                    ->sortable(),
                StyledToggleColumn::create('show_on_public')
                    ->label('Public')
                    ->sortable(),
                StyledToggleColumn::create('is_members_only')
                    ->label('Members Only')
                    ->sortable(),
                TextColumn::make('starts_at')
                    ->label('From')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->label('Until')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
