<?php

namespace Database\Factories;

use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => $this->faker->phoneNumber,
            'gender' => rand(1,2),
            'born_at' => $this->faker->dateTimeBetween($startDate = '-35 years', $endDate = '-25 years'),
            'password' => Hash::make('12345678'),
            'snils' => rand(10000000000, 99999999999),
            'remember_token' => Str::random(10),
            'last_sign_in_at' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now')
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
