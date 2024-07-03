<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\Question;
use Illuminate\Support\Arr;
use App\Http\Classes\QuestionType;
use App\Models\QuestionOption;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuestionOptionTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * Galderak badu aukera
     */
    public function test_option_belongs_to_question(): void
    {
        $poll = Poll::factory()->create();
        $question = Question::factory()->create(['poll_id' => $poll->id, 'type' => QuestionType::CLOSE]);
        $option = QuestionOption::factory()->create(['question_id' => $question->id]);

        $expectedQuestionArray = Arr::only($question->toArray(), ['question', 'type', 'poll_id']);
        $resultQuestionArray = Arr::only($option->question->toArray(), ['question', 'type', 'poll_id']);
        
        $this->assertEquals($expectedQuestionArray, $resultQuestionArray);
    }
    
}
