<?php

namespace Tests\Feature\Poll;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\User;
use App\Models\Polled;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\DataProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontAnswerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Kontu batekin logeatu.
     */
    public function setUp(): void
    {
        parent::setUp();

        $user = User::where('id', '=', 1)->first();
        if (is_null($user)) {
            $user = User::factory()->create();
        }
        $this->actingAs($user);
    }


    public function test_polledCreate_screen_can_be_rendered(): void
    {
        $response = $this->get(route('front.polled'));
        $response->assertStatus(200);
        $response->assertViewIs('front.polled');
    }
    public function test_polledCreate_screen_cant_be_rendered_when_logout(): void
    {
        auth()->logout();
        $response = $this->get(route('front.polled'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /**
     * Test validation when storing data wrong
     */
    public static function storeNameDataProvider(): array
    {
        return [
            ['', 'name'],
            [[], 'name'],
            [null, 'name'],

        ];
    }
    #[DataProvider('storeNameDataProvider')]
    public function test_store_polled_name_invalid($name, $errorField): void
    {
        $response = $this->post(route('front.polledCreate', [$errorField => $name]));
        $response->assertStatus(302);
        $response->assertInvalid($errorField);
    }

    /**
     * Test validation when storing data incorrectly
     */
    public static function storeDataProvider(): array
    {
        return [
            ['Valid name', 'a', 'email'],
            ['Valid name', ['asd', '@', 'qwe'], 'email'],

            ['Valid name', 'asd', 'jaiotzeData'],
            ['Valid name', date('d-m-Y'), 'jaiotzeData'],

            ['Valid name', Str::random(6), 'postalCode'],
            ['Valid name', ['asd'], 'postalCode'],

            ['Valid name', Str::random(21), 'genre'],
            ['Valid name', ['asd'], 'genre'],

        ];
    }
    #[DataProvider('storeDataProvider')]
    public function test_store_polled_invalid($name, $value, $errorField): void
    {
        $response = $this->post(route('front.polledCreate', ['name' => $name, $errorField => $value]));
        $response->assertStatus(302);
        $response->assertInvalid($errorField);
    }

    public static function storeValidDataProvider(): array
    {
        return [
            ['Valid name', '', '', '', ''],
            ['Valid name', [], [], [], []],
            ['Valid name', null, null, null, null,],
            ['Valid name', 'a@a', date('Y-m-d'), '20180', 'Gizona'],
        ];
    }
    #[DataProvider('storeValidDataProvider')]
    public function test_store_polled_valid($name, $email, $date, $code, $genre): void
    {
        $response = $this->post(route('front.polledCreate', ['name' => $name, 'email' => $email, 'jaiotzeData' => $date, 'postalCode' => $code, 'genre' => $genre]));
        $response->assertSessionDoesntHaveErrors(['name', 'email', 'jaiotzeData', 'postalCode', 'genre']);
        $response->assertStatus(302);
        $polled = Polled::latest()->first();
        $response->assertRedirect(route('front.polls', $polled));
    }

    /**
     * Test render front.polls when loged and not
     */
    public static function pollsDataProvider(): array
    {
        return array(
            [200, true],
            [302, false],
        );
    }
    #[DataProvider('pollsDataProvider')]
    public function test_front_polls($status, $loged): void
    {
        $polled = Polled::factory()->create();
        if ($loged) {
            $response = $this->get(route('front.polls', $polled));
            $response->assertStatus($status);
            $response->assertViewIs('front.polls');
            $response->assertViewHas('polled', $polled);
        } else {
            auth()->logout();
            $response = $this->get(route('front.polls', $polled));
            $response->assertStatus($status);
            $response->assertRedirect(route('login'));
        }
    }

    public function test_create_answer_can_be_rendered():void 
    {
        $poll = Poll::factory()->create();
        $polled = Polled::factory()->create();
        $response = $this->get(route('front.create',[$polled, $poll]));
        $response->assertStatus(200);
        $response->assertViewHas(['poll', 'polled']);
        $response->assertViewIs('front.create');
    }
    public function test_create_answer_cant_be_rendered_when_logout():void 
    {
        Auth()->logout();
        $poll = Poll::factory()->create();
        $polled = Polled::factory()->create();
        $response = $this->get(route('front.create',[$polled, $poll]));
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
    /**
     * Answers is incorrect when storing frontAnswer
     */
    public static function storeDataProviderInvalid(): array
    {
        return [
            [null],
            [''],
        ];
    }
    
    #[DataProvider('storeDataProviderInvalid')]
    public function test_store_front_answer_invalid($answers)
    {
        $poll = Poll::factory()->create();
        $polled = Polled::factory()->create();
    
        $response = $this->post(route('front.store', [$polled, $poll]), ['answer' => $answers]);
    
        $response->assertStatus(302);  
        $response->assertSessionHasErrors('answer');
    }
    /**
     * Answers.* is incorrect when storing frontAnswer
     */
    public static function storeAnswerDataProvider():array
    {
        return [
            [[null]],
            [[1]],
            [['']],
        ];
    }
    #[DataProvider('storeAnswerDataProvider')]
    public function test_store_front_answerArray_invalid($answers)
    {
        $poll = Poll::factory()->create();
        $polled = Polled::factory()->create();
    
        $response = $this->post(route('front.store', [$polled, $poll]), ['answer' => $answers]);
    
        $response->assertStatus(302);
        $response->assertSessionHasErrors('answer.*');
    }
    /**
     * Store correctly frontAnswer
     */
    public function test_store_front_answerArray_valid()
    {
        $poll = Poll::factory()->create();
        $polled = Polled::factory()->create();
        $answers = [
            1 => 'First valid answer',
            2 => 'Second valid answer',
        ];
        $response = $this->post(route('front.store', [$polled, $poll]), ['answer' => $answers]);
    
        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors(['answers', 'answers.*']);
        $response->assertRedirect(route('answers.index'));
    }

}
