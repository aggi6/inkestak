<?php

namespace Tests\Feature\PollAnswer;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\Polled;
use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nette\Utils\Random;

class CreatePollAnswerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Kontu batekin logeatu.
     */
    public function setUp(): void
    {
        parent::setUp();

        $user = User::firstOrCreate(['id' => 1], [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);
    }

    /**
     * Render Tests (index, create) (loged and not)
     */
    public static function renderDataProvider(): array
    {
        return array(
            ['answers.index', 200, true],
            ['answers.index', 302, false],
            ['answers.create', 200, true],
            ['answers.create', 302, false],
        );
    }
    #[DataProvider('renderDataProvider')]
    public function test_answer_screen_can_be_rendered($route, $status, $loged): void
    {
        if ($loged) {
            $response = $this->get(route($route));
            $response->assertStatus($status);
            $response->assertViewIs($route);
        } else {
            auth()->logout();
            $response = $this->get(route($route));
            $response->assertStatus($status);
            $response->assertRedirect(route('login'));
        }
    }

    /**
     * Test validation when storing data wrong
     */
    public static function answerDataProvider(): array
    {
        return [
            [1, 1, '', 'polled_id', 'valid asnwer'],
            [1, '', 1, 'question_id', 'valid asnwer'],
            ['', 1, 1, 'poll_id', 'valid asnwer'],
            [1, 1, 1, 'answer', ''],
            [1, 1, 1, 'answer', []],
            [1, 1, 1, 'answer', null],
        ];
    }
    #[DataProvider('answerDataProvider')]
    public function test_store_answer_invalid($poll_id, $question_id, $polled_id, $errorField, $answer): void
    {
        Poll::factory()->create(['id' => 1]);
        Question::factory()->create(['id' => 1]);
        Polled::factory()->create(['id' => 1]);
        $response = $this->post(route('answers.store', ['poll_id' => $poll_id, 'question_id' => $question_id, 'polled_id' => $polled_id, 'answer' => $answer]));
        $response->assertStatus(302);
        $response->assertInvalid($errorField);
    }

     /**
     * Test validation when storing data correctly
     */
    public function test_store_answer_valid(): void
    {
        $poll = Poll::factory()->create();
        $question = Question::factory()->create();
        $polled = Polled::factory()->create();
        $response = $this->post(route('answers.store', ['poll_id' => $poll->id, 'question_id' => $question->id, 'polled_id' => $polled->id, 'answer' => 'Valid answer']));
        $response->assertSessionDoesntHaveErrors(['poll_id', 'question_id', 'polled_id', 'answer']);
        $response->assertStatus(302);
        $response->assertRedirect(route('answers.index'));
    }
}
