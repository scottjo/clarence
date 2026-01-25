<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IntroBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\IntroBlock::create([
            'page_identifier' => 'home',
            'content' => '<h2>Welcome to Clarence Bowls Club</h2><p>Established in 1907, Clarence Bowls Club is one of the most prestigious bowling clubs in the West of England. Situated in the beautiful Clarence Park, just a stone\'s throw from the seafront in Weston-super-Mare, we offer excellent facilities for both competitive and casual bowlers.</p><p>Our club boasts two of the finest greens in the county, a comfortable clubhouse with licensed bar, and a vibrant social calendar. Whether you are an experienced player or a complete beginner, you will find a warm welcome at Clarence.</p>',
            'is_active' => true,
        ]);

        \App\Models\IntroBlock::create([
            'page_identifier' => 'about',
            'content' => '<h2>Our Rich History</h2><p>Clarence Bowls Club has been a cornerstone of the Weston-super-Mare sporting community for over a century. Our members have achieved success at local, county, and national levels, but we remain committed to the spirit of friendly competition and community.</p>',
            'left_image' => null,
            'right_image' => null,
            'is_active' => true,
        ]);
    }
}
