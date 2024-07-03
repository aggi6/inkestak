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
    public function test_all_answers_are_bai(): void
{
    PollAnswer::factory()->create(['poll_id' => '99999', 'polled_id' => '3', 'question_id' => '902', 'answer' => 'Bai']);
    PollAnswer::factory()->create(['poll_id' => '99999', 'polled_id' => '3', 'question_id' => '902', 'answer' => 'Bai']);
    PollAnswer::factory()->create(['poll_id' => '99999', 'polled_id' => '3', 'question_id' => '902', 'answer' => 'Bai']); 
    $answers = PollAnswer::pluck('answer');
    foreach ($answers as $answer) {
        $this->assertEquals('Bai', $answer);
    }
}
public function test_all_answers_are_ez(): void
{
    $pollAnswer1 = PollAnswer::factory()->create(['poll_id' => '99999', 'polled_id' => '3', 'question_id' => '902', 'answer' => 'Ez']);
    $pollAnswer2 = PollAnswer::factory()->create(['poll_id' => '99999', 'polled_id' => '3', 'question_id' => '902', 'answer' => 'Ez']);
    $pollAnswer3 = PollAnswer::factory()->create(['poll_id' => '99999', 'polled_id' => '3', 'question_id' => '902', 'answer' => 'Baiasd']);
    $pollAsnwersArray = [$pollAnswer1, $pollAnswer2, $pollAnswer3];
    $answers = PollAnswer::pluck('answer', 'id');
    foreach ($pollAsnwersArray as $pollAnswer){
        $this->assertArrayHasKey($pollAnswer->id , $answers);
        $this->assertEquals($pollAnswer->answer, $answers[$pollAnswer->id]);
    }
}

}
