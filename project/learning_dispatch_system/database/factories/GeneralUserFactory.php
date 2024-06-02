<?php

namespace Database\Factories;

use App\Services\UserService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeneralUser>
 */
class GeneralUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => app()->make(UserService::class)->uniqueUserId(),
            'email'        => fake()->email(),
            'password'     => \Hash::make('test'),
            'family_name'  => fake()->lastName(),
            'name'         => fake()->firstName(),
            'usage_status' => \CommonConst::ACCOUNT_USAGE
        ];
    }
}
