<?php

namespace App\Filament\Resources\KnownMemberEmails\Pages;

use App\Filament\Resources\KnownMemberEmails\KnownMemberEmailResource;
use App\Models\KnownMemberEmail;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ListKnownMemberEmails extends ListRecords
{
    protected static string $resource = KnownMemberEmailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importCsv')
                ->label('Import CSV')
                ->color('info')
                ->form([
                    FileUpload::make('csv_file')
                        ->label('CSV file')
                        ->helperText('Upload a CSV with Name in the first column and Email in the second column. The first row should be the header row.')
                        ->required()
                        ->acceptedFileTypes([
                            'text/csv',
                            'text/plain',
                            'application/csv',
                            'application/vnd.ms-excel',
                        ])
                        ->disk('local')
                        ->directory('temp'),
                ])
                ->action(function (array $data): void {
                    $csvFile = $data['csv_file'];
                    $filePath = Storage::disk('local')->path($csvFile);
                    $handle = fopen($filePath, 'r');

                    if ($handle === false) {
                        Notification::make()
                            ->title('Invalid CSV file')
                            ->danger()
                            ->send();

                        return;
                    }

                    if (fgetcsv($handle) === false) {
                        fclose($handle);
                        Storage::disk('local')->delete($csvFile);

                        Notification::make()
                            ->title('Invalid CSV file')
                            ->danger()
                            ->send();

                        return;
                    }

                    $importedCount = 0;
                    $skippedCount = 0;

                    DB::beginTransaction();

                    try {
                        while (($row = fgetcsv($handle)) !== false) {
                            if (count($row) < 2) {
                                $skippedCount++;

                                continue;
                            }

                            $name = trim($row[0]);
                            $email = strtolower(trim($row[1]));

                            if ($email === '') {
                                $skippedCount++;

                                continue;
                            }

                            KnownMemberEmail::query()->updateOrCreate(
                                ['email' => $email],
                                ['name' => $name !== '' ? $name : null],
                            );

                            $importedCount++;
                        }

                        DB::commit();

                        Notification::make()
                            ->title("Imported {$importedCount} known member emails")
                            ->body($skippedCount > 0 ? "Skipped {$skippedCount} rows with blank or missing email addresses." : null)
                            ->success()
                            ->send();
                    } catch (Throwable $exception) {
                        DB::rollBack();

                        Notification::make()
                            ->title('Import failed')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    } finally {
                        fclose($handle);
                        Storage::disk('local')->delete($csvFile);
                    }
                }),
            CreateAction::make(),
        ];
    }
}
