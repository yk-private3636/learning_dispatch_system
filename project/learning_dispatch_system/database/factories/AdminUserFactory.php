<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminUser>
 */
class AdminUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email'        => fake()->email(),
            'password'     => \Hash::make('test'),
            'family_name'  => fake()-> lastName(),
            'name'         => fake()-> firstName(),
            'usage_status' => \CommonConst::ACCOUNT_USAGE,
            'mistake_num'  => 0
        ];
    }
}
