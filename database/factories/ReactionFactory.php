<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;

class ReactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'react_type' => $this->faker->randomElement(["like","love","wow"]),
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
        ];
    }
}
