<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Question;
use App\Models\Poll;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'a@a',
            'password' => 'asdasdasd',
        ]);
        Poll::factory()->create([
            'name' => 'Programadoreentzat inkesta',
            'date' => '2024-05-16',
        ]);
        Question::factory()->create([
            'question' => 'Ze programazio lengoaia erabiltzen duzu?',
            'poll_id' => 1,
        ]);
        Question::factory()->create([
            'question' => 'Ze gustatzen zaizu gehiago Frontend ala Backend?',
            'poll_id' => 1,
        ]);
    }
}
