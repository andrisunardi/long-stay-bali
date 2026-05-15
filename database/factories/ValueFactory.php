<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ValueFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence();
        $shortDescription = fake()->unique()->paragraph();
        $description = fake()->unique()->paragraph();

        return [
            'title' => fake()->unique()->sentence(),
            'title_id' => (new GoogleTranslate('id'))->translate($title),
            'title_zh' => (new GoogleTranslate('zh'))->translate($title),
            'title_fr' => (new GoogleTranslate('fr'))->translate($title),
            'short_description' => fake()->paragraph(),
            'short_description_id' => (new GoogleTranslate('id'))->translate($shortDescription),
            'short_description_zh' => (new GoogleTranslate('zh'))->translate($shortDescription),
            'short_description_fr' => (new GoogleTranslate('fr'))->translate($shortDescription),
            'description' => fake()->paragraph(),
            'description_id' => (new GoogleTranslate('id'))->translate($description),
            'description_zh' => (new GoogleTranslate('zh'))->translate($description),
            'description_fr' => (new GoogleTranslate('fr'))->translate($description),
            'icon' => 'fas fa-icons',
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
