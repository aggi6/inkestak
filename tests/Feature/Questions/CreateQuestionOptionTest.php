<?php

declare(strict_types=1);

namespace Tests\Feature\Auth\Questions;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Str;
use App\Http\Classes\QuestionType;
use App\Models\QuestionOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Attributes\DataProvider;

class CreateQuestionOptionTest extends TestCase
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


    public function test_createQuestionOption_screen_can_be_rendered(): void
    {
        $poll = Poll::factory()->create();

        $response = $this->get(route('questions.create', ['poll' => $poll]));

        $response->assertStatus(200);

        $response->assertViewIs('questions.create');

        $response->assertViewHas('poll', $poll);

        // $viewPoll = $response->viewData('poll');
    }

    public function test_createQuestionOption_screen_cant_be_rendered_ifNotLogged(): void
    {
        auth()->logout();

        $poll = Poll::factory()->create();

        $response = $this->get(route('questions.create', ['poll' => $poll]));

        $response->assertStatus(500);
    }

    #[DataProvider('questionType_dataProvider')]
    public function test_storeQuestionOption_null($questionType): void
    {
        $poll = Poll::factory()->create();
        $question = [
            'question' => 'Example question',
            'type' => $questionType,
        ];

        $question['options'] = null;

        $response = $this->from(route('questions.create', ['poll' => $poll]))
            ->post(route('questions.store', ['poll' => $poll]), $question);

        $response->assertStatus(302);

        $response->assertRedirect(route('questions.create', ['poll' => $poll]));

        $response->assertInvalid(['options']);
    }

    public function test_storeQuestionOption_without(): void
    {
        $poll = Poll::factory()->create();

        // Datos de la pregunta con el tipo 'CLOSE' pero sin opciones
        $questionData = [
            'question' => 'Example question',
            'type' => QuestionType::CLOSE,
        ];

        // Enviar una solicitud POST a la ruta para crear una nueva pregunta
        $response = $this->post(route('questions.store', $poll), $questionData);

        // Verificar que la respuesta tiene un estado 302 (redirige después de fallar la validación)
        $response->assertStatus(302);

        // Verificar que la sesión contiene errores de validación para el campo 'options'
        $response->assertSessionHasErrors('options');
        $errors = session('errors');
        $this->assertEquals(['The options field is required.'], $errors->get('options'));
    }

    public function test_storeQuestionOption_notString(): void
    {
        $poll = Poll::factory()->create();
        $question = ['question' => 'asd', 'type' => QuestionType::CLOSE, 'options' => [1]];
        $response = $this->post(route('questions.store', ['poll' => $poll]), $question);

        $response->assertStatus(302);

        $response->assertInvalid(['options.0' => 'The options.0 field must be a string.']);
    }

    public function test_storeQuestionOption_max50(): void
    {
        $poll = Poll::factory()->create();

        $questionData = [
            'question' => 'Valid question text',
            'type' => QuestionType::CLOSE,
            'options' => [Str::random(51)],
        ];
        $response = $this->from(route('questions.create', ['poll' => $poll]))
            ->post(route('questions.store', ['poll' => $poll]), $questionData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'options.0' => 'The options.0 field must not be greater than 50 characters.',
        ]);
        $response->assertRedirect(route('questions.create', ['poll' => $poll]));
    }

    public function test_storeQuestionOption_required(): void
    {
        $poll = Poll::factory()->create();

        $questionData = [
            'question' => 'Valid question text',
            'type' => QuestionType::CLOSE,
            'options' => [null],
        ];
        $response = $this->from(route('questions.create', ['poll' => $poll]))
            ->post(route('questions.store', ['poll' => $poll]), $questionData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'options.0' => 'The options.0 field is required.',
        ]);
        $response->assertRedirect(route('questions.create', ['poll' => $poll]));
    }

    public function test_storeQuestionOption_success(): void
    {
        $poll = Poll::factory()->create();
        $questionData = [
            'question' => 'Example question',
            'type' => QuestionType::CLOSE,
            'options' => ['Option 1']
        ];

        $optionCount = QuestionOption::count();
        $response = $this->from(route('questions.create', ['poll' => $poll]))
            ->post(route('questions.store', ['poll' => $poll]), $questionData);

        $response->assertStatus(302);

        $response->assertSessionHasNoErrors();

        $response->assertRedirect(route('polls.index'));

        $this->assertDatabaseHas('questions', [
            'question' => 'Example question',
            'type' => QuestionType::CLOSE,
            'poll_id' => $poll->id,
        ]);

        $this->assertEquals($optionCount + 1, QuestionOption::count());

        $lastQuestionOption = QuestionOption::latest()->first();

        $this->assertEquals('Option 1', $lastQuestionOption->option);
    }
    public function test_storeQuestionOptionOpen_error(): void
    {
        $poll = Poll::factory()->create();
        $questionData = [
            'question' => 'Example question',
            'type' => QuestionType::OPEN,
            'options' => ['Option 1']
        ];

        $optionCount = QuestionOption::count();
        $response = $this->from(route('questions.create', ['poll' => $poll]))
            ->post(route('questions.store', ['poll' => $poll]), $questionData);

        $response->assertStatus(302);

        $response->assertRedirect(route('questions.create', ['poll' => $poll]));
    }
    public static function questionType_dataProvider(): array
    {
        return array(
            array(QuestionType::OPEN),
            array(QuestionType::CLOSE),
        );
    }
}
