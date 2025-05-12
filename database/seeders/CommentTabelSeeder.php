<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       if (User::count() === 0 || Task::count() === 0) {
            $this->command->warn("You need to seed 'users' and 'tasks' tables before 'comments'.");
            return;
        }

          Comment::factory()->count(20)->create([
            'parent_id' => null,
        ]);

             Comment::factory()->count(30)->create([
            'parent_id' => fn () => Comment::inRandomOrder()->first()->id,
        ]);
    }
}
