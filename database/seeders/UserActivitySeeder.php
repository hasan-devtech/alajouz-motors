<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UserActivitySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();
        foreach ($users as $user) {
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon::now()->subDays($i);
                $sessionsCount = rand(1, 2);
                for ($j = 0; $j < $sessionsCount; $j++) {
                    $checkedIn = Carbon::createFromTime(rand(8, 11), rand(0, 59))
                        ->setDate($date->year, $date->month, $date->day);
                    $checkedOut = (clone $checkedIn)->addHours(rand(3, 5))->addMinutes(rand(0, 59));
                    UserActivity::create([
                        'user_id' => $user->id,
                        'device_id' => $faker->uuid,
                        'ip' => $faker->ipv4,
                        'latitude' => $faker->latitude(),
                        'longitude' => $faker->longitude(),
                        'checked_in' => $checkedIn,
                        'checked_out' => $checkedOut,
                        'notes' => $faker->sentence(),
                    ]);
                }
            }
        }
    }
}
