<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Vermaysha\Wilayah\Models\Village;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fake = fake('id_ID');

        return [
            'village_id' => Village::inRandomOrder()->limit(1)->first()->id,
            'postal_code' => $fake->postcode(),
            'address_line' => $fake->streetAddress(),
            'coordinates' => new Point($fake->latitude(), $fake->longitude()),
        ];
    }
}
