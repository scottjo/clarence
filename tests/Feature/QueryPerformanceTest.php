<?php

namespace Tests\Feature;

use App\Models\Fixture;
use App\Models\OfficerClassification;
use App\Models\Result;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class QueryPerformanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Collect queries hitting specific tables during a callback.
     *
     * @param  array<string>  $tables
     * @return array<string>
     */
    private function captureQueriesFor(array $tables, callable $callback): array
    {
        $queries = [];

        DB::listen(function ($query) use ($tables, &$queries): void {
            foreach ($tables as $table) {
                if (str_contains($query->sql, $table)) {
                    $queries[] = $query->sql;
                    break;
                }
            }
        });

        $callback();

        DB::flushQueryLog();

        return $queries;
    }

    public function test_officers_page_does_not_have_n_plus_one_on_classifications(): void
    {
        $classification1 = OfficerClassification::factory()->create(['sort_order' => 1]);
        $classification2 = OfficerClassification::factory()->create(['sort_order' => 2]);

        \App\Models\Officer::factory()->count(5)->create([
            'classification_id' => $classification1->id,
            'is_active' => true,
        ]);
        \App\Models\Officer::factory()->count(5)->create([
            'classification_id' => $classification2->id,
            'is_active' => true,
        ]);

        $queries = $this->captureQueriesFor(['officer_classifications'], function (): void {
            $this->get(route('about.officers'))->assertStatus(200);
        });

        // Eager loading should produce exactly 1 query on officer_classifications,
        // not 1 per officer (which would be 10+).
        $this->assertLessThanOrEqual(2, count($queries),
            'Expected at most 2 classification queries (eager load), got '.count($queries).': '.implode("\n", $queries)
        );
    }

    public function test_results_page_does_not_have_n_plus_one_on_fixtures(): void
    {
        Result::factory()->count(10)->create();

        $queries = $this->captureQueriesFor(['fixtures'], function (): void {
            $this->get(route('results'))->assertStatus(200);
        });

        // Eager loading should produce a bounded number of fixture queries,
        // not 1 per result row.
        $this->assertLessThanOrEqual(3, count($queries),
            'Expected at most 3 fixture queries (eager load + join + possible count), got '.count($queries).': '.implode("\n", $queries)
        );
    }

    public function test_search_results_does_not_have_n_plus_one_on_fixtures(): void
    {
        $fixtures = Fixture::factory()->count(5)->create(['opponent' => 'Searchable Club']);

        foreach ($fixtures as $fixture) {
            Result::factory()->create([
                'fixture_id' => $fixture->id,
                'summary' => 'Searchable match summary',
            ]);
        }

        $queries = $this->captureQueriesFor(['fixtures'], function (): void {
            $this->get(route('search', ['q' => 'Searchable']))->assertStatus(200);
        });

        // Eager loading should keep fixture queries bounded,
        // not 1 per result row rendered.
        $this->assertLessThanOrEqual(4, count($queries),
            'Expected at most 4 fixture queries (search + eager load), got '.count($queries).': '.implode("\n", $queries)
        );
    }
}
