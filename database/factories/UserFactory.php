<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'nume'         => fake()->lastName(),
            'prenume'      => fake()->firstName(),
            'email'        => fake()->unique()->safeEmail(),
            'parola'       => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'cnp'          => fake()->unique()->numerify('#############'),
            'data_nastere' => fake()->date()
        ];
    }
}
