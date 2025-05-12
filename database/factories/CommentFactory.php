<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'user_id'=>User::inRandomOrder()->first()?->id,
           'task_id'=>Task::inRandomOrder()->first()?->id,
           'body'=> $this->faker->paragraph,
           'parent_id' => Comment::inRandomOrder()->first()?->id
        ];
    }
}
