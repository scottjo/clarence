<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $winners = \Illuminate\Support\Facades\DB::table('competition_winners')->get();

        foreach ($winners as $winner) {
            $names = json_decode($winner->names, true);

            if ($winner->no_competition || empty($names)) {
                \Illuminate\Support\Facades\DB::table('competition_results')->insert([
                    'competition_id' => $winner->competition_id,
                    'year' => $winner->year,
                    'category' => $winner->category,
                    'winner_name' => null,
                    'no_competition' => true,
                    'created_at' => $winner->created_at,
                    'updated_at' => $winner->updated_at,
                ]);
            } else {
                foreach ($names as $nameData) {
                    \Illuminate\Support\Facades\DB::table('competition_results')->insert([
                        'competition_id' => $winner->competition_id,
                        'year' => $winner->year,
                        'category' => $winner->category,
                        'winner_name' => $nameData['name'] ?? '',
                        'no_competition' => false,
                        'created_at' => $winner->created_at,
                        'updated_at' => $winner->updated_at,
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('competition_results')->truncate();
    }
};
