<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Notifications\UserApprovedNotification;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (): bool => ! $this->record->isApproved())
                ->action(function (): void {
                    $this->record->approve();
                    $this->record->notify(new UserApprovedNotification);

                    Notification::make()
                        ->title('User approved')
                        ->success()
                        ->send();
                }),
            DeleteAction::make(),
        ];
    }
}
