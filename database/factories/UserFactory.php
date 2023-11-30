<?php

namespace Database\Factories;

use App\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = GenderEnum::cases();
        $phoneCode = ['+91', '+1', '+90', '+971'];
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'username' => str((fake()->unique()->userName()))->slug(''),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone_code' => $phoneCode[array_rand($phoneCode)],
            'phone' => str_replace('+', '',fake()->unique()->e164PhoneNumber()),
            // 'is_phone_verified',
            'phone_verified_at' => now(),
            'address' => fake()->address(),
            'country' => fake()->country(),
            'currency' => fake()->currencyCode(),
            'dob' => fake()->date(),
            'gender' => $gender[array_rand($gender)],
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
