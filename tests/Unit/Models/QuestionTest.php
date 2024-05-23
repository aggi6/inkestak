<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\User;
use App\Models\Question;
use App\Models\PollAnswer;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuestionTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * Galderaren badu inkesta
     */
    public function test_question_belongsTo_poll(): void
    {
        $poll = Poll::factory()->create([
            'name' => 'Programadoasdreentzat inkesta',
            'date' => '2024-05-16',
        ]);

        $question = Question::factory()->create([
            'question' => 'Ze programazio lengoaia erabiltzen duzu?',
            'poll_id' => $poll->id,
        ]);

        $expectedPollArray = Arr::only($poll->toArray(), ['name', 'date', 'id']);

        $resultPollArray = Arr::only($question->poll->toArray(), ['name', 'date', 'id']);

        $this->assertEquals($expectedPollArray, $resultPollArray);
    }
    
}
