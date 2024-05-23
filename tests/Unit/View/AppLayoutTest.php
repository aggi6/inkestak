<?php

namespace Tests\Unit\Policies;

use Tests\TestCase;
use Illuminate\Support\Arr;
use App\Policies\PollPolicy;
use App\View\Components\AppLayout;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AppLayoutTest extends TestCase
{
    use DatabaseMigrations;
    private $appLayout;
    public function setUp():void{
        parent::setUp();
        $this->appLayout= app(AppLayout::class);
    }

    public function test_appLayout_correct_view(): void
    {
        $expectedView = view('layouts.app');
        $this->assertEquals($expectedView, $this->appLayout->render());
    }
}
