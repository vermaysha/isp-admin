<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = fake('id_ID');
        $gender = $faker->randomElement(['male', 'female']);

        return [
            'username' => $faker->unique()->userName(),
            'email' => $faker->unique()->safeEmail(),
            'password' => Hash::make(('password')),
            'fullname' => $faker->name($gender),
            'photo' => 'assets/img/avatars/' . $faker->numberBetween(1, 30) . '.jpg',
            'address' => $faker->address(),
            'nik' => $faker->nik(),
            'phone_number' => $faker->e164PhoneNumber(),
            'ktp_file' => 'example.jpg',
            'birth' => $faker->dateTimeBetween(),
            'gender' => $gender,
            'remember_token' => Str::random(10),
        ];
    }
}
