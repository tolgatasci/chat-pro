<?php

namespace TolgaTasci\Chat\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use TolgaTasci\Chat\Tests\Stubs\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // veya Hash::make('password')
            'remember_token' => Str::random(10),
        ];
    }
}
