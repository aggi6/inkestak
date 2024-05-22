<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\User;
use App\Models\Question;
use App\Models\PollAnswer;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PollTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * Inkestak ez du galderarik
     */
    public function test_poll_empty_questions(): void
    {
        $poll = Poll::factory()->create([
            'name' => 'Programadoasdreentzat inkesta',
            'date' => '2024-05-16',
        ]);

        $this->assertEmpty($poll->question);
    }
    public function test_poll_has_a_question(): void
    {
        $poll = Poll::factory()->create([
            'name' => 'Programadoasdreentzat inkesta',
            'date' => '2024-05-16',
        ]);
        $question = Question::factory()->create([
            'question' => 'Ze programazio lengoaia erabiltzen duzu?',
            'poll_id' => $poll->id,
        ]);
        
        $this->assertCount(1, $poll->question);
        
        $expectedQuestion = Arr::only($question->toArray(), ['id', 'question', 'poll_id']);

        $resultQuestion = Arr::only($poll->question->first()->toArray(), ['id', 'question', 'poll_id']);

        $this->assertEquals($expectedQuestion, $resultQuestion);
        

        $this->assertEquals($question->id, $poll->question->first()->id);

        $this->assertEquals(Question::class, get_class($poll->question->first()));


        $this->assertTrue($poll->question->contains($question));
    }
    public function test_poll_many_questions(): void
    {
        $poll = Poll::factory()->create([
            'name' => 'Programadoasdreentzat inkesta',
            'date' => '2024-05-16',
        ]);
        $questions = Question::factory(4)->create([
            'question' => 'Ze programazio lengoaia erabiltzen duzu?',
            'poll_id' => $poll->id,
        ]);

        $this->assertNotEmpty($poll->question);
        $this->assertCount(4, $poll->question);
        foreach ($questions as $question){
            $this->assertTrue($poll->question->contains($question));
        }
    }
    public function test_poll_isAdmin(): void
    {
        $user = User::where('id', '=' ,1)->first();
        if (is_null($user)){
            $user = User::factory()->create();
        }
        $this->actingAs($user);
        $poll = Poll::factory()->create([
            'name' => 'asd',
            'date' => date('Y-m-d H:i:s')
        ]);
        $this->assertTrue($poll->isAdmin());
    }
    public function test_poll_isNotAdmin(): void
    {
        $user = User::where('id', '!=' ,1)->first();
        if (is_null($user)){
            $user = User::factory(2)->create()->last();
        }
        $this->actingAs($user);
        $poll = Poll::factory()->create([
            'name' => 'asd',
            'date' => date('Y-m-d H:i:s')
        ]);
        $this->assertFalse($poll->isAdmin());
    }
}
