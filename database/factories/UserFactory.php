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
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        
        return [
            // Laravel Breeze original
            'name' => $firstName . ' ' . $lastName,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            
            // Nouveaux champs e-commerce
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => fake()->phoneNumber(),
            'birth_date' => fake()->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'address_line_1' => fake()->streetAddress(),
            'address_line_2' => fake()->optional(0.3)->secondaryAddress(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'country' => 'France',
            'preferences' => [
                'favorite_categories' => fake()->randomElements(['parfums', 'maquillage', 'soins'], rand(1, 2)),
                'newsletter_frequency' => fake()->randomElement(['weekly', 'monthly']),
                'language' => 'fr'
            ],
            'newsletter_subscribed' => fake()->boolean(70), // 70% de chance d'être abonné
            'role' => 'customer',
            'is_active' => true,
            'total_spent' => fake()->randomFloat(2, 0, 1000),
            'orders_count' => fake()->numberBetween(0, 10),
            'last_login_at' => fake()->optional(0.8)->dateTimeBetween('-30 days', 'now'),
            'last_login_ip' => fake()->ipv4(),
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

    /**
     * Indicate that the user should be an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'preferences' => [
                'language' => 'fr',
                'notifications' => true,
                'dashboard_theme' => 'light'
            ]
        ]);
    }

    /**
     * Indicate that the user should be a super admin.
     */
    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'super_admin',
            'preferences' => [
                'language' => 'fr',
                'notifications' => true,
                'dashboard_theme' => 'light'
            ]
        ]);
    }

    /**
     * Indicate that the user should be a VIP customer.
     */
    public function vip(): static
    {
        return $this->state(fn (array $attributes) => [
            'total_spent' => fake()->randomFloat(2, 500, 3000),
            'orders_count' => fake()->numberBetween(5, 20),
            'newsletter_subscribed' => true,
            'preferences' => [
                'favorite_categories' => ['parfums', 'maquillage', 'soins'],
                'favorite_brands' => fake()->randomElements(['Chanel', 'Dior', 'YSL', 'Hermès'], rand(2, 3)),
                'vip_status' => true
            ]
        ]);
    }

    /**
     * Indicate that the user should be a new customer.
     */
    public function newCustomer(): static
    {
        return $this->state(fn (array $attributes) => [
            'total_spent' => 0,
            'orders_count' => 0,
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'last_login_at' => fake()->optional(0.5)->dateTimeBetween('-7 days', 'now'),
        ]);
    }
}