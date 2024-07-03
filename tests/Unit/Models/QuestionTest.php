<?php

namespace Tests\Unit\Models;

use App\Http\Classes\QuestionType;
use Tests\TestCase;
use App\Models\Poll;
use App\Models\User;
use App\Models\Question;
use App\Models\PollAnswer;
use App\Models\QuestionOption;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuestionTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * Galderak badu inkesta
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
    /**
     * Galderak baditu aukera
     */
    public function test_question_has_one_option():void {
        $question = Question::factory()->create(['type' => QuestionType::CLOSE]);
        $option = QuestionOption::factory()->create(['question_id' => $question->id]);
        //contains
        $this->assertTrue($question->options->contains($option));
    }
    /**
     * Galderak aukera ezberdin asko ditu
     */
    public function test_question_has_many_options():void {
        $question = Question::factory()->create(['type' => QuestionType::CLOSE]);
        $question2 = Question::factory()->create(['type' => QuestionType::CLOSE]);

        $options = QuestionOption::factory(10)->create(['question_id' => $question->id]);
        $options2 = QuestionOption::factory(10)->create(['question_id' => $question2->id]);

        //contains
        foreach ($options as $option){
            $this->assertTrue($question->options->contains($option));
        }
        foreach ($options2 as $option){
            $this->assertFalse($question->options->contains($option));
        }
    }
    /**
     * Galdera batek ez euki aukera
     */
    public function test_question_has_no_option():void {
        $question = Question::factory()->create(['type' => QuestionType::CLOSE]);
                $this->assertEmpty($question->options);
    }
}
