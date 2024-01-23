<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Src\Domain\User\Enums\Roles;
use Src\Domain\User\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function admin()
    {
        $role = Role::firstOrCreate(
            ['name' => Roles::SUPER_ADMIN], ['name' => Roles::SUPER_ADMIN, 'guard_name' => 'web']
        );
        return $this->hasAttached($role);
    }

    public function withRole(string $roleName)
    {
        $role = Role::firstOrCreate(
            ['name' => $roleName], ['name' => $roleName, 'guard_name' => 'web']
        );
        return $this->hasAttached($role);
    }
}
