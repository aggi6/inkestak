<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\User;
use App\Models\Polled;
use App\Models\Question;
use App\Models\PollAnswer;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AnswerTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * Inkestak ez du galderarik
     */
    public function test_answer_belongsTo_question(): void
    {
        $poll = Poll::factory()->create([
            'name' => 'Programadoasdreentzat inkesta',
            'date' => '2024-05-16',
        ]);
        $question = Question::factory()->create();
        $polled = Polled::factory()->create();
        $answer = PollAnswer::factory()->create([
            'question_id'=>$question->id,
            'poll_id'=>$poll->id,
            'polled_id'=>$polled->id,
            'answer'=>'12asd',
        ]);
        $expectedQuestion = Arr::only($question->toArray(), ['id','question']);
        $resultQuestion = Arr::only($answer->question->toArray(), ['id','question']);
        $this->assertEquals($expectedQuestion, $resultQuestion);
    }
}
