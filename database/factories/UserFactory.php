<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\UserStatusEnum;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName, 
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->generateSyrianPhoneNumber(),
            'hired_date' => $this->faker->optional()->dateTimeBetween('-2 years', 'now'),
            'salary' => $this->faker->numberBetween(3000, 10000),
            'status' => $this->faker->randomElement([
                UserStatusEnum::Active->value,
                UserStatusEnum::Disabled->value,
            ]),
            'password' => 'h123456789H',
        ];
    }

    private function generateSyrianPhoneNumber()
    {
        $prefix = $this->faker->randomElement(['09', '+963']);
        $number = '';
        for ($i = 0; $i < 8; $i++) {
            $number .= $this->faker->numberBetween(3, 9);
        }
        return $prefix . $number;
    }
}
