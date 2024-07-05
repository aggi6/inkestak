<?php

namespace Tests\Feature\Poll;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\User;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class PollTest extends TestCase
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

    /**
     * Render Tests (index, create) (loged and not)
     */
    public static function renderDataProvider(): array
    {
        return array(
            ['polls.index', 200, true],
            ['polls.index', 302, false],
            ['polls.create', 200, true],
            ['polls.create', 302, false],
            ['polls.trash', 200, true],
            ['polls.trash', 302, false],
        );
    }
    #[DataProvider('renderDataProvider')]
    public function test_poll_screen_can_be_rendered($route, $status, $loged): void
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
    public static function storeDataProvider(): array
    {
        return [
            ['', date('Y-m-d'), 'name'],
            [null, date('Y-m-d'), 'name'],
            [[2], date('Y-m-d'), 'name'],
            [Str::random(256), date('Y-m-d'), 'name'],

            ['poll name', 'asd', 'date'],
            ['poll name', [2], 'date'],
            ['poll name', date('d-m-Y'), 'date'],
        ];
    }

    /**
     * Test validation when storing data correctly
     */
    #[DataProvider('storeDataProvider')]
    public function test_store_poll_invalid($name, $date, $errorField): void
    {
        $response = $this->post(route('polls.store', ['name' => $name, 'date' => $date]));
        $response->assertStatus(302);
        $response->assertInvalid($errorField);
    }
    public static function storeValidDataProvider(): array
    {
        return [
            ['poll name', ''],
            ['poll name', null],
            ['poll name', date('Y-m-d')],
        ];
    }
    #[DataProvider('storeValidDataProvider')]
    public function test_store_poll_valid($name, $date): void
    {
        $response = $this->post(route('polls.store', ['name' => $name, 'date' => $date]));
        $response->assertSessionDoesntHaveErrors(['name', 'date']);
        $response->assertStatus(302);
        $response->assertRedirect(route('polls.index'));
    }

    /**
     * Test render poll.edit when loged and not
     */
    public static function editDataProvider(): array
    {
        return array(
            [200, true],
            [302, false],
        );
    }
    #[DataProvider('editDataProvider')]
    public function test_edit_poll($status, $loged): void
    {
        $poll = Poll::factory()->create();
        if ($loged) {
            $response = $this->get(route('polls.edit', $poll));
            $response->assertStatus($status);
            $response->assertViewIs('polls.edit');
            $response->assertViewHas('poll', $poll);
        } else {
            auth()->logout();
            $response = $this->get(route('polls.edit', $poll));
            $response->assertStatus($status);
            $response->assertRedirect(route('login'));
        }
    }

    /**
     * Test validation when updating data uncorrectly
     */
    public static function updateDataProviderInvalid(): array
    {
        return [
            ['', date('Y-m-d'), ['name']],
            [null, date('Y-m-d'), ['name']],
            [[2], date('Y-m-d'), ['name']],
            [Str::random(256), date('Y-m-d'), ['name']],
            ['poll name', 'asd', ['date']],
            ['poll name', [2], ['date']],
            ['poll name', date('d-m-Y'), ['date']],
            ['', 'asd', ['date', 'name']],

        ];
    }
    #[DataProvider('updateDataProviderInvalid')]
    public function test_update_poll_invalid($name, $date, $field)
    {
        $poll = Poll::factory()->create();
        $response = $this->patch(route('polls.update', $poll), ['name' => $name, 'date' => $date]);
        $response->assertStatus(302);
        $response->assertInvalid($field);
    }

    /**
     * Test validation when updating correctly
     */
    public static function updateDataProviderValid(): array
    {
        return [
            ['poll name', ''],
            ['poll name', null],
            ['poll name', date('Y-m-d')],
        ];
    }
    #[DataProvider('updateDataProviderValid')]
    public function test_update_poll_valid($name, $date)
    {
        $poll = Poll::factory()->create();
        $response = $this->patch(route('polls.update', $poll), ['name' => $name, 'date' => $date]);
        $response->assertSessionDoesntHaveErrors(['name', 'date']);
        $response->assertStatus(302);
        $response->assertRedirect(route('polls.index'));
    }

    /**
     * Testing if delete work correctly and redirects
     */
    public function test_delete_poll(): void
    {
        $poll = Poll::factory()->create();

        $response = $this->delete(route('polls.destroy', $poll));

        $response->assertStatus(302);
        
        $response->assertRedirect(route('polls.index'));
        
        $this->assertDatabaseHas('polls', ['id' => $poll->id]);
        
        $pollExists = Poll::find($poll->id);
        $this->assertNull($pollExists);

        $pollExists = Poll::withTrashed()->find($poll->id);
        $this->assertNotNull($pollExists->deleted_at);
    }

    /**
     * If user isn't logged cannot delete poll 
     */
    public function test_unlogged_cannot_delete(): void
    {
        Auth()->logout();
        $poll = Poll::factory()->create();

        $response = $this->delete(route('polls.destroy', $poll));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('polls', ['id' => $poll->id]);

        $pollExists = Poll::find($poll->id);
        $this->assertNull($pollExists->deleted_at);
    }

    /**
     * Test logged user can restore soft deleted row
     */
    public function test_restore_poll():void
    {
        $poll = Poll::factory()->create(['deleted_at' => date('Y-m-d')]);
        $response = $this->patch(route('polls.restore', $poll->id));
        $response->assertStatus(302);
        $poll->refresh();
        $this->assertNull($poll->deleted_at);
    }

     /**
     * Test unlogged user cannot restore soft deleted row
     */
    public function test_unlogged_cannot_restore_poll():void
    {
        Auth()->logout();
        $poll = Poll::factory()->create(['deleted_at' => date('Y-m-d')]);
        $response = $this->patch(route('polls.restore', $poll->id));
        $response->assertStatus(302);
        $poll->refresh();
        $this->assertNotNull($poll->deleted_at);
    }


}
