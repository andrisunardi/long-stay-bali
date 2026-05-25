<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    public function definition(): array
    {
        $district = District::first() ?? District::factory()->hotel()->create();

        return [
            'district_id' => $district->id,
            'name' => fake()->unique()->name(),
            'is_promoted' => fake()->boolean(),
            'is_show' => fake()->boolean(),
            'is_active' => fake()->boolean(),
        ];
    }

    public function promoted(): static
    {
        return $this->state(fn () => ['is_promoted' => true]);
    }

    public function notPromoted(): static
    {
        return $this->state(fn () => ['is_promoted' => false]);
    }

    public function show(): static
    {
        return $this->state(fn () => ['is_show' => true]);
    }

    public function notShown(): static
    {
        return $this->state(fn () => ['is_show' => false]);
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
