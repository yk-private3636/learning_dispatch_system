<?php

namespace Database\Factories;

use App\Services\Admin\Login\PasswordResetService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ResetPasswordTokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
            'token' => app()->make(PasswordResetService::class)->createToken(),
            'user_division' => rand(\UserEnum::GENERAL->division(), \UserEnum::ADMIN->division())
        ];
    }
}
