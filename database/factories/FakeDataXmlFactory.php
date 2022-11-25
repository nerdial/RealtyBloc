<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FakeDataXml>
 */
class FakeDataXmlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'body' => $this->faker->text,
            'country' => $this->faker->country,
            'image_address' => 'https://images.theconversation.com/files/236755/original/file-20180917-158216-t52jx0.jpg?ixlib=rb-1.1.0&q=45&auto=format&w=1200&h=1200.0&fit=crop',
            'width' => $this->faker->randomFloat(),
            'height' => $this->faker->randomFloat(),
            'price' => $this->faker->randomFloat(),
            'address' => $this->faker->address,
            'lat' => $this->faker->latitude(),
            'lng' => $this->faker->longitude(),
            'type' => $this->faker->randomElement(['type1', 'type2', 'type3']),
        ];
    }
}
