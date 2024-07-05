<?php declare(strict_types=1);

namespace Tests\Feature\Auth\Questions;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Str;
use App\Http\Classes\QuestionType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
class CreateQuestionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::where('id', '=', 1)->first();
        if (is_null($user)) {
            $user = User::factory()->create();
        }
        $this->actingAs($user);
    }

    // public function tearDown() :void
    // {

    //    //code

    //     parent::tearDown();
    // }


    public function test_createQuestion_screen_can_be_rendered(): void
    {
        $poll = Poll::factory()->create();

        $response = $this->get(route('questions.create', ['poll' => $poll]));

        $response->assertStatus(200);

        $response->assertViewIs('questions.create');

        $response->assertViewHas('poll', $poll);

        // $viewPoll = $response->viewData('poll');
    }

    public function test_createQuestion_screen_cant_be_rendered_ifNotLogged(): void
    {
        auth()->logout();

        $poll = Poll::factory()->create();

        $response = $this->get(route('questions.create', ['poll' => $poll]));

        $response->assertStatus(500);
    }
    public function test_storeQuestion_null(): void
    {
        $poll = Poll::factory()->create();

        $response = $this->post(route('questions.store', ['poll' => $poll]), ['question' => null]);
        
        $response->assertStatus(302);

        $response->assertInvalid('question');
    }

    public function test_storeQuestion_without(): void
    {
        $poll = Poll::factory()->create();

        $response = $this->post(route('questions.store', ['poll' => $poll]));

        $response->assertStatus(302);

        $response->assertInvalid('question');
    }
    public function test_storeQuestion_notString(): void
    {
        $poll = Poll::factory()->create();

        $response = $this->post(route('questions.store', ['poll' => $poll]), ['question' => [1]]);

        $response->assertStatus(302);
        $response->assertInvalid('question');
    }
    public function test_storeQuestion_max255(): void
    {

        $poll = Poll::factory()->create();

        $response = $this->from(route('questions.create', ['poll' => $poll]))
            ->post(route('questions.store', ['poll' => $poll]), ['question' => Str::random(256)]);

        $response->assertStatus(302);
        $response->assertInvalid('question');
        $response->assertRedirect(route('questions.create', ['poll' => $poll]));
    }
    public function test_storeQuestion_type_must_be_open_or_close(): void
    {

        $poll = Poll::factory()->create();

        $response = $this->from(route('questions.create', ['poll' => $poll]))
            ->post(route('questions.store', ['poll' => $poll]), ['type' => Str::random(2)]);

        $response->assertStatus(302);
        $response->assertInvalid('type');
        $response->assertRedirect(route('questions.create', ['poll' => $poll]));
    }
    public static function questionType_dataProvider(): array
    {
        return array(
            array(QuestionType::OPEN, []),
            array(QuestionType::CLOSE, ['options' => ['asd']]),
        );
    }
    #[DataProvider('questionType_dataProvider')]
    public function test_storeQuestion_success_when_type_open_or_close($questionType, $options): void
    {
        $poll = Poll::factory()->create();
        $question = Question::factory(['type' => $questionType])->make();

        $questionCount = Question::count();
        //assertDatabaseMissing

        $response = $this->from(route('questions.create', $poll))
            ->post(route('questions.store', ['poll' => $poll]), $options + $question->toArray());

        $response->assertStatus(302);

        $response->assertValid();

        $response->assertRedirect(route('polls.index'));

        $this->assertEquals($questionCount + 1, Question::count());

        $lastQuestion = Question::latest()->first();

        $this->assertEquals($question->question, $lastQuestion->question);
    }
    
}
