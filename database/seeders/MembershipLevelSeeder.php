<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MembershipLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\MembershipLevel::create([
            'name' => 'Full Member',
            'cost' => 120.00,
            'benefits' => 'Unlimited use of the green and entry to all club competitions.',
            'sort_order' => 1,
        ]);

        \App\Models\MembershipLevel::create([
            'name' => 'Junior Member',
            'cost' => 30.00,
            'benefits' => 'For those under 18 years of age. Includes coaching and games.',
            'sort_order' => 2,
        ]);

        \App\Models\MembershipLevel::create([
            'name' => 'Social Member',
            'cost' => 20.00,
            'benefits' => 'Enjoy use of the clubhouse and social events, without bowling rights.',
            'sort_order' => 3,
        ]);
    }
}
