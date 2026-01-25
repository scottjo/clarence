<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::create([
            'club_name' => 'Clarence Bowls Club',
            'address' => "Clarence Park\nWeston-super-Mare\nBS23 1PA",
            'phone' => '01934 123456',
            'email' => 'info@clarencebowls.co.uk',
            'menu_color' => '#ffffff',
            'footer_color' => '#ffffff',
            'menu_text_color' => '#2563eb',
            'footer_text_color' => '#6b7280',
            'page_bg_color' => '#f9fafb',
            'header_gradient_start' => '#ffffff',
            'header_gradient_end' => '#ffffff',
            'header_gradient_direction' => 'to right',
            'footer_gradient_start' => '#ffffff',
            'footer_gradient_end' => '#ffffff',
            'footer_gradient_direction' => 'to right',
        ]);
    }
}
