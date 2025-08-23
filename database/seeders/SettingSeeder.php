<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Outerweb\Settings\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'timezone' => 'Asia/Damascus',
            'checkin_max_distance' => 0.05,
            'company_latitude' => 33.532436,
            'company_longitude' => 36.228012,
            'min_amount' => 100,
            'min_rental_days' => 1,
            'booking_working_days' => ['saturday','sunday','monday','tuesday','wednesday','thursday'],
        ];
        foreach ($settings as $key => $value) {
            Setting::create([
                'key' => $key,
                'value' => $value
            ]);
        }
    }
}
