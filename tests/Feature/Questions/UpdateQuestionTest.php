<?php

namespace Tests\Feature\Auth\Questions;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateQuestionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $user = User::where('id', '=' ,1)->first();
        if (is_null($user)){
            $user = User::factory()->create();
        }
        $this->actingAs($user);
    }

    // public function tearDown() :void
    // {

    //    //code

    //     parent::tearDown();
    // }


    public function test_editQuestion_screen_can_be_rendered(): void
    {
        $question = Question::factory()->create();

        $response = $this->get(route('questions.edit', ['question' => $question]));

        $response->assertStatus(200);

        $response->assertViewIs('questions.edit');

        $response->assertViewHas('question', $question);

        // Optionally, retrieve view data for further assertions if needed
        // $viewQuestion = $response->viewData('question');
        // $this->assertEquals($question->id, $viewQuestion->id);
    }
    public function test_editQuestion_screen_cant_be_rendered_ifNotLogged(): void
    {
        auth()->logout();

        $question = Question::factory()->create();

        $response = $this->get(route('questions.edit', ['question'=>$question]));

        $response->assertStatus(500);
    }
    public function test_updateQuestion_null(): void
    {
        $question = Question::factory()->create();

        $response = $this->patch(route('questions.update', ['question'=>$question]), ['question' => null]);
        
        $response->assertStatus(302);

        $response->assertInvalid('question');
    }
    public function test_updateQuestion_without(): void
    {
        $question = Question::factory()->create();

        $response = $this->patch(route('questions.update', ['question'=>$question]));

        $response->assertStatus(302);

        $response->assertInvalid('question');
    }
    public function test_updateQuestion_notString(): void
    {
        $question = Question::factory()->create();

        $response = $this->patch(route('questions.update', ['question'=>$question]), ['question' => [1]]);

        $response->assertStatus(302);
        $response->assertInvalid('question');
    }
    public function test_updateQuestion_max255(): void
    {
       
        $question = Question::factory()->create();

        $response = $this->from(route('questions.edit', ['question'=>$question]))
        ->patch(route('questions.update', ['question'=>$question]), ['question' => Str::random(256)]);

        $response->assertStatus(302);
        $response->assertInvalid('question');
        $response->assertRedirect(route('questions.edit', ['question'=>$question]));
    }
    public function test_updateQuestion_success(): void
    {
        $question = Question::factory()->create();
        //assertDatabaseMissing

        $expectedQuestion = $question->question . Str::random(16);
        $response = $this->from(route('questions.edit', ['question'=>$question]))
    ->patch(route('questions.update', ['question'=>$question]),['question' => $expectedQuestion]+$question->toArray());

        $response->assertStatus(302);

        $response->assertValid();

        $response->assertRedirect(route('polls.index'));

        $this->assertDatabaseHas('questions', ['id'=>$question->id, 'question'=>$expectedQuestion]);
    }
}