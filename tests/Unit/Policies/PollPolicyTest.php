<?php

namespace Tests\Unit\Policies;

use Tests\TestCase;
use App\Models\Poll;
use App\Models\User;
use App\Models\Polled;
use App\Models\Question;
use App\Models\PollAnswer;
use Illuminate\Support\Arr;
use App\Policies\PollPolicy;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PollPolicyTest extends TestCase
{
    use DatabaseMigrations;
    private $pollPolicy;
    public function setUp():void{
        parent::setUp();
        // $pollPolicy = new PollPolicy();
        // $pollPolicy = App::make(PollPolicy::class);
        $this->pollPolicy = app(PollPolicy::class);
    }

    public function test_is_admin_on_create(): void
    {
        $user= $this->get_admin_user();
        $this->assertTrue($this->pollPolicy->create($user));
    }
    public function test_is_not_admin_on_create(): void
    {
        $user= $this->get_non_admin_user();

        $this->assertFalse($this->pollPolicy->create($user));
    }
    public function test_is_admin_on_update(): void
    {
        $user= $this->get_admin_user();

        $this->assertTrue($this->pollPolicy->update($user));
    }
    public function test_is_not_admin_on_update(): void
    {
        $user= $this->get_non_admin_user();
        $this->assertFalse($this->pollPolicy->update($user));
    }
    private function get_admin_user():User{
        $user = User::where('id', '=' ,1)->first();
        if (is_null($user)){
            $user = User::factory()->create();
        }
        return $user;
    }
    private function get_non_admin_user():User{
        $user = User::where('id', '!=' ,1)->first();
        if (is_null($user)){
            $user = User::factory(2)->create()->last();
        }
        return $user;
    }
}
