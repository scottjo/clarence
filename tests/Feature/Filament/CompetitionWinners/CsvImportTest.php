<?php

namespace Tests\Feature\Filament\CompetitionWinners;

use App\Filament\Resources\CompetitionWinners\Pages\ListCompetitionWinners;
use App\Models\Competition;
use App\Models\CompetitionResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class CsvImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_import_csv_with_competition_results()
    {
        $user = User::factory()->create();
        $competition = Competition::create([
            'name' => 'Handicap',
            'category' => 'Both',
            'sort_order' => 1,
        ]);

        Storage::fake('local');

        $csvContent = "year,competition,type,name\n";
        $csvContent .= "2025,Handicap,Men,John Doe\n";
        $csvContent .= "2025,Handicap,Ladies,Jane Doe\n";
        $csvContent .= "2025,Invalid Comp,Men,No Competition\n";

        $file = UploadedFile::fake()->createWithContent('winners.csv', $csvContent);

        Livewire::actingAs($user)
            ->test(ListCompetitionWinners::class)
            ->callAction('importCsv', [
                'csv_file' => $file,
            ])
            ->assertHasNoActionErrors();

        $this->assertEquals(2, CompetitionResult::count());
        $this->assertDatabaseHas('competition_results', [
            'year' => 2025,
            'competition_id' => $competition->id,
            'category' => 'Men',
            'winner_name' => 'John Doe',
        ]);
        $this->assertDatabaseHas('competition_results', [
            'year' => 2025,
            'competition_id' => $competition->id,
            'category' => 'Ladies',
            'winner_name' => 'Jane Doe',
        ]);
    }
}
