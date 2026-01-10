<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->freeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'username' => fake()->unique()->userName(),
            'password' => Hash::make(12345678),
            'image_url' => fake()->imageUrl(),
            'is_active' => fake()->boolean(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['is_active' => true]);
    }

    public function inActive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
