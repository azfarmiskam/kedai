<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SystemSetting::create([
            'system_name' => 'Kedai',
            'site_description' => 'Build your online store with ease. Perfect for students, startups, and SMEs.',
            'color_primary' => '#1e3a8a', // Navy Blue
            'color_secondary' => '#3b82f6', // Light Blue
            'color_tertiary' => '#60a5fa', // Lighter Blue
            'default_language' => 'en',
            'default_currency' => 'RM',
        ]);
    }
}
