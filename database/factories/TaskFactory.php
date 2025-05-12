<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
     protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

      return [
        'title' => $this->faker->unique()->sentence(4),
        'description' => $this->faker->paragraph(),
        'user_id' => User::where('rule', 'admin')->inRandomOrder()->value('id'),
        'due_date' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
    ];
    }
}
