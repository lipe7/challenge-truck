<?php

namespace Database\Factories;

use App\Domain\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->randomNumber(),
            'status' => $this->faker->randomElement(['draft', 'trash', 'published']),
            'imported_t' => now(),
            'url' => $this->faker->url(),
            'creator' => $this->faker->name(),
            'created_t' => now(),
            'last_modified_t' => now(),
            'product_name' => $this->faker->word(),
            'quantity' => $this->faker->randomNumber(),
            'brands' => $this->faker->words(3, true),
            'categories' => $this->faker->words(3, true),
            'labels' => $this->faker->words(3, true),
            'cities' => $this->faker->city(),
            'purchase_places' => $this->faker->words(3, true),
            'stores' => $this->faker->words(3, true),
            'ingredients_text' => $this->faker->text(),
            'traces' => $this->faker->words(3, true),
            'serving_size' => $this->faker->randomNumber(),
            'serving_quantity' => $this->faker->randomFloat(2, 1, 100),
            'nutriscore_score' => $this->faker->numberBetween(0, 100),
            'nutriscore_grade' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'main_category' => $this->faker->word(),
            'image_url' => $this->faker->imageUrl(),
        ];
    }
}
