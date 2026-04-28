<?php

namespace App\Filament\Resources\Leagues\Pages;

use App\Filament\Resources\Leagues\LeagueResource;
use App\Models\LeagueStanding;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditLeague extends EditRecord
{
    protected static string $resource = LeagueResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importStandings')
                ->label('Import Standings')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    TextInput::make('season')
                        ->placeholder('e.g. 2024')
                        ->required(),
                    Textarea::make('standings')
                        ->label('Paste Standings')
                        ->placeholder('1 CLARENCE BLUES 2 2 0 0 5 0 7 0 217 179 38 26')
                        ->rows(20)
                        ->required(),
                ])
                ->action(function (array $data) {
                    $lines = explode("\n", $data['standings']);
                    $importedCount = 0;

                    // Clear existing standings for this season
                    $this->record->standings()->where('season', $data['season'])->delete();

                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (empty($line)) {
                            continue;
                        }

                        // Regex to match: [Rank] [Team Name] [12 numbers]
                        // We use a regex that captures the rank, the team name (non-numeric), and then the 12 numbers.
                        // However, team names might contain numbers sometimes? Usually not in this context.
                        // Let's use a more robust approach: split by whitespace and take the last 12 as stats.
                        $parts = preg_split('/\s+/', $line);

                        if (count($parts) < 14) {
                            continue; // Need at least Rank + Team + 12 stats
                        }

                        $points = (int) array_pop($parts);
                        $diff = (int) array_pop($parts);
                        $a = (int) array_pop($parts);
                        $f = (int) array_pop($parts);
                        $not_complete = (int) array_pop($parts);
                        $rinks_lost = (int) array_pop($parts);
                        $rinks_drawn = (int) array_pop($parts);
                        $rinks_won = (int) array_pop($parts);
                        $l = (int) array_pop($parts);
                        $d = (int) array_pop($parts);
                        $w = (int) array_pop($parts);
                        $p = (int) array_pop($parts);

                        array_shift($parts); // Remove rank
                        $teamName = implode(' ', $parts);

                        LeagueStanding::create([
                            'league_id' => $this->record->id,
                            'season' => $data['season'],
                            'team_name' => $teamName,
                            'played' => $p,
                            'won' => $w,
                            'drawn' => $d,
                            'lost' => $l,
                            'rinks_won' => $rinks_won,
                            'rinks_drawn' => $rinks_drawn,
                            'rinks_lost' => $rinks_lost,
                            'not_complete' => $not_complete,
                            'points_for' => $f,
                            'points_against' => $a,
                            'points_difference' => $diff,
                            'points' => $points,
                            'sort_order' => $importedCount,
                        ]);

                        $importedCount++;
                    }

                    Notification::make()
                        ->title("Imported {$importedCount} teams successfully.")
                        ->success()
                        ->send();
                }),
            DeleteAction::make(),
        ];
    }
}
