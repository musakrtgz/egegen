<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(1, true),
            'slug' => $this->faker->unique()->slug,
            'image' => $this->faker->imageUrl(640, 480, 'news'),
            'is_active' => $this->faker->boolean(80), // %80 ihtimalle aktif
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // 1 yıl öncesi ile şimdi arasında rastgele tarih
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
