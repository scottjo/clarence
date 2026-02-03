<?php

namespace App\Filament\Resources\CompetitionWinners\Pages;

use App\Filament\Resources\CompetitionWinners\CompetitionWinnerResource;
use App\Models\Competition;
use App\Models\CompetitionResult;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ListCompetitionWinners extends ListRecords
{
    protected static string $resource = CompetitionWinnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importCsv')
                ->label('Import CSV')
                ->color('info')
                ->form([
                    FileUpload::make('csv_file')
                        ->label('CSV File')
                        ->required()
                        ->acceptedFileTypes(['text/csv', 'application/csv'])
                        ->disk('local')
                        ->directory('temp'),
                ])
                ->action(function (array $data) {
                    $csvFile = $data['csv_file'];
                    $filePath = Storage::disk('local')->path($csvFile);
                    $handle = fopen($filePath, 'r');

                    // Read header
                    $header = fgetcsv($handle);

                    if (! $header) {
                        Notification::make()
                            ->title('Invalid CSV file')
                            ->danger()
                            ->send();

                        return;
                    }

                    $competitions = Competition::all();
                    $importedCount = 0;
                    $mismatches = [];

                    DB::beginTransaction();

                    try {
                        while (($row = fgetcsv($handle)) !== false) {
                            // Expected columns: year, competition, type, name or no competition
                            if (count($row) < 4) {
                                continue;
                            }

                            [$year, $competitionName, $type, $winnerOrNoComp] = $row;

                            $competition = $competitions->first(fn ($c) => strtolower($c->name) === strtolower($competitionName));

                            if (! $competition) {
                                $mismatches[] = $competitionName;

                                continue;
                            }

                            $noCompetition = strtolower($winnerOrNoComp) === 'no competition';

                            CompetitionResult::create([
                                'year' => (int) $year,
                                'competition_id' => $competition->id,
                                'category' => in_array(ucfirst(strtolower($type)), ['Men', 'Ladies']) ? ucfirst(strtolower($type)) : null,
                                'winner_name' => $noCompetition ? null : $winnerOrNoComp,
                                'no_competition' => $noCompetition,
                            ]);

                            $importedCount++;
                        }

                        DB::commit();

                        $mismatches = array_unique($mismatches);

                        $notification = Notification::make()
                            ->title("Imported {$importedCount} records")
                            ->success();

                        if (count($mismatches) > 0) {
                            $notification->body('Warning: Mismatching competition names: '.implode(', ', $mismatches))
                                ->warning();
                        }

                        $notification->send();

                    } catch (\Exception $e) {
                        DB::rollBack();
                        Notification::make()
                            ->title('Import failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    } finally {
                        fclose($handle);
                        Storage::disk('local')->delete($data['csv_file']);
                    }
                }),
            CreateAction::make(),
        ];
    }
}
