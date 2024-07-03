<?php

namespace Database\Seeders;

use App\Models\Poll;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;
use App\Http\Classes\QuestionType;

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
        // Poll::factory()->create([
        //     'name' => 'Programadoreentzat inkesta',
        //     'date' => '2024-05-16',
        // ]);
        // Poll::factory(100)->create([
        //     'name' => 'Programadoasdreentzat inkesta',
        //     'date' => '2024-05-16',
        // ]);
        // Poll::factory(100)->create([
        //     'name' => 'Programadoasdreentzat inkesta',
        //     'date' => '2024-05-16',
        // ]);
        // Poll::factory(100)->create([
        //     'name' => 'Programadoasdreentzat inkesta',
        //     'date' => '2024-05-16',
        // ]);
        // Poll::factory(100)->create([
        //     'name' => 'Programadoasdreentzat inkesta',
        //     'date' => '2024-05-16',
        // ]);
        // Poll::factory(100)->create([
        //     'name' => 'Programadoasdreentzat inkesta',
        //     'date' => '2024-05-16',
        // ]);
        // Poll::factory(100)->create([
        //     'name' => 'Programadoasdreentzat inkesta',
        //     'date' => '2024-05-16',
        // ]);
        // Poll::factory(100)->create([
        //     'name' => 'Programadoasdreentzat inkesta',
        //     'date' => '2024-05-16',
        // ]);
        // Poll::factory(100)->create([
        //     'name' => 'Programadoasdreentzat inkesta',
        //     'date' => '2024-05-16',
        // ]);
        // Poll::factory(100)->create([
        //     'name' => 'Programadoasdreentzat inkesta',
        //     'date' => '2024-05-16',
        // ]);
        // $questions = Question::factory(10)->create([
        //     'question' => 'Ze programazio lengoaia erabiltzen duzu? (itxia)',
        //     'poll_id' => 1,
        //     'type' => QuestionType::CLOSE,
        // ]);
        // foreach ($questions as $question) {
        //     for ($i = 0; $i < rand(2, 10); $i++) {
        //         QuestionOption::factory()->create([
        //             'question_id' => $question->id,
        //         ]);
        //     }
        // }
        // Question::factory(100)->create([
        //     'question' => 'Ze programazio lengoaia erabiltzen duzu?',
        //     'poll_id' => 1,
        // ]);
        // Question::factory(100)->create([
        //     'question' => 'Ze programazio lengoaia erabiltzen duzu?',
        //     'poll_id' => 1,
        // ]);
        // Question::factory(100)->create([
        //     'question' => 'Ze programazio lengoaia erabiltzen duzu?',
        //     'poll_id' => 1,
        // ]);
        // Question::factory(100)->create([
        //     'question' => 'Ze programazio lengoaia erabiltzen duzu?',
        //     'poll_id' => 1,
        // ]);
        // Question::factory(100)->create([
        //     'question' => 'Ze programazio lengoaia erabiltzen duzu?',
        //     'poll_id' => 1,
        // ]);
        // Question::factory(100)->create([
        //     'question' => 'Ze programazio lengoaia erabiltzen duzu?',
        //     'poll_id' => 1,
        // ]);
        // Question::factory(100)->create([
        //     'question' => 'Ze programazio lengoaia erabiltzen duzu?',
        //     'poll_id' => 1,
        // ]);
        // Question::factory(100)->create([
        //     'question' => 'Ze programazio lengoaia erabiltzen duzu?',
        //     'poll_id' => 1,
        // ]);
        // Question::factory()->create([
        //     'question' => 'Ze gustatzen zaizu gehiago Frontend ala Backend?',
        //     'poll_id' => 1,
        // ]);
    }
}
