<?php

namespace Database\Seeders;

use App\Models\UsefulContact;
use Illuminate\Database\Seeder;

class UsefulContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UsefulContact::create([
            'title' => 'Club Secretary',
            'name' => 'John Doe',
            'telephone' => '01234 567890',
            'email' => 'secretary@example.com',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        UsefulContact::create([
            'title' => 'Membership Secretary',
            'name' => 'Jane Smith',
            'telephone' => '01234 567891',
            'email' => 'membership@example.com',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        UsefulContact::create([
            'title' => 'Match Secretary',
            'name' => 'Bob Brown',
            'telephone' => '01234 567892',
            'email' => 'matches@example.com',
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
