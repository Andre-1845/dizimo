<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123456A#'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Cria automaticamente o Member associado
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            Member::factory()->create([
                'user_id' => $user->id,
                'name'    => $user->name,
            ]);
        });
    }

    /**
     * Indica que o e-mail não foi verificado
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}