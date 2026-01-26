<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            [
                'title' => 'Our Green',
                'description' => 'We boast one of the finest bowling greens in the region, meticulously maintained throughout the season to provide a consistent and enjoyable playing surface for all levels.',
                'image_position' => 'left',
                'sort_order' => 1,
            ],
            [
                'title' => 'Clubhouse',
                'description' => "Our clubhouse features a spacious lounge area, a fully licensed bar, and catering facilities. It's the perfect place to relax after a match or host club events.",
                'image_position' => 'right',
                'sort_order' => 2,
            ],
            [
                'title' => 'Changing Rooms',
                'description' => 'Separate changing facilities for men and women are available, including lockers for secure storage of your belongings during play.',
                'image_position' => 'left',
                'sort_order' => 3,
            ],
            [
                'title' => 'Parking',
                'description' => 'Ample on-site parking is available for members and visitors, ensuring easy access to our facilities.',
                'image_position' => 'right',
                'sort_order' => 4,
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
