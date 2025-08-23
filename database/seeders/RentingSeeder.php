<?php

namespace Database\Seeders;

use App\Enums\CarListingTypeEnum;
use App\Enums\RequestStatusEnum;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Renting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RentingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = Car::where('mood', CarListingTypeEnum::Rent->value)->pluck('id')->toArray();
        $customers = Customer::pluck('id')->toArray();
        $statuses = RequestStatusEnum::cases();
        foreach ($customers as $customerId) {
            $rentingCount = 15;
            for ($i = 0; $i <= $rentingCount; $i++) {
                $carId = $cars[array_rand($cars)];
                $rentalDays = rand(1, 7);
                $startDate = Carbon::today()->addDays(rand(0, 15));
                $endDate = (clone $startDate)->addDays($rentalDays);
                $pricePerDay = Car::find($carId)->price;
                $totalPrice = $pricePerDay * ($rentalDays + 1);
                Renting::create([
                    'car_id' => $carId,
                    'customer_id' => $customerId,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'total_price' => $totalPrice,
                    'status' => $statuses[array_rand($statuses)]->value,
                    'license' => 'licenses/sample_license_' . $customerId . '.pdf',
                ]);
            }
        }
    }
}
