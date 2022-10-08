<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category = $this->faker->randomElement(["apparel", "book", "electronic device",]);
        $apparel = $this->faker->randomElement(["jacket", "T-Shirt", "Polo"]);
        $book = $this->faker->randomElement(["The Book", "A Book", "Thy Book"]);
        $electronic_device = $this->faker->randomElement(["Phone", "Laptop", "Pager"]);
        $currency = $this->faker->randomElement(["PHP", "USD"]);

        $title = "";

        if ($category == "apparel")
            $title = $apparel;
        else if ($category == "book")
            $title = $book;
        else if ($category == "electronic device")
            $title = $electronic_device;

        return [
            'title' => $title,
            'description' => "The Given " . $title . " Description",
            'currency' => $currency,
            'price' => $this->faker->numberBetween(1.0, 100000.0),
            'brand' => $this->faker->company(),
            'category' => $category,
            'image' => 'https://netstorage-kami.akamaized.net/images/0fgjhs1shmj74jpi4g.jpg?&imwidth=1200'
        ];
    }
}
