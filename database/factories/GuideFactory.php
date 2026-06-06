<?php

namespace Database\Factories;

use App\Models\GuideCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GuideFactory extends Factory
{
    public function definition(): array
    {
        $guideCategory = GuideCategory::first() ?? GuideCategory::factory()->hotel()->create();

        $title = fake()->title();
        $slug = Str::slug($title);

        return [
            'guide_category_id' => $guideCategory->id,
            'title' => fake()->unique()->sentence(),
            'title_id' => fake()->unique()->sentence(),
            'title_zh' => fake()->unique()->sentence(),
            'title_fr' => fake()->unique()->sentence(),
            'body' => fake()->paragraph(),
            'body_id' => fake()->paragraph(),
            'body_zh' => fake()->paragraph(),
            'body_fr' => fake()->paragraph(),
            'google_file_id' => fake()->uuid(),
            'image_url' => fake()->imageUrl(),
            'is_show' => fake()->boolean(),
            'is_active' => fake()->boolean(),
            'slug' => $slug,
            'counter' => fake()->numberBetween(0, 1000000000),
        ];
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
