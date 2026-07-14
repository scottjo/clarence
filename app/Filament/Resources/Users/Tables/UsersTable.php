<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\UserRole;
use App\Filament\Columns\StyledToggleColumn;
use App\Models\User;
use App\Notifications\UserApprovedNotification;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('roles')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => UserRole::from($state)->getLabel()),
                TextColumn::make('approved_at')
                    ->label('Approval')
                    ->badge()
                    ->state(fn (User $record): string => $record->isApproved() ? 'Approved' : 'Pending')
                    ->color(fn (string $state): string => $state === 'Approved' ? 'success' : 'warning'),
                StyledToggleColumn::create('is_admin')
                    ->label('Legacy Admin')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('approved_at')
                    ->label('Approved')
                    ->nullable(),
            ])
            ->recordActions([
                Action::make('approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (User $record): bool => ! $record->isApproved())
                    ->action(function (User $record): void {
                        $record->approve();
                        $record->notify(new UserApprovedNotification);

                        Notification::make()
                            ->title('User approved')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
