<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Http\Classes\QuestionType;
use App\Http\Requests\QuestionRequest;
use PHPUnit\Framework\Attributes\DataProvider;

class QuestionRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    #[DataProvider('dataProvider')]
    public function test_question_validations($field, $value, $expected): void
    {
        $questionRequestRules = (new QuestionRequest())->rules();
        $validator = $this->app['validator'];
        $result = $validator->make(
            [$field => $value],
            [$field => $questionRequestRules[$field]]
        )->passes();
        $this->assertEquals($expected, $result);
    }
    public static function dataProvider(): array
    {
        return [
            ['type', QuestionType::OPEN, true],
            ['type', QuestionType::CLOSE, true],
            ['type', null, false],
            ['type', '', false],
            ['type', 'asd', false],
            ['type', ['asd'], false],
            ['question', 'kaixo', true],
            ['question', null, false],
            ['question', ' ', false],
            ['question', Str::random(256), false],
            ['question', ['kaixo'], false],
        ];
    }
}
//QuestionRequest Provider adibidea
    // [
    //     [QuestionType::OPEN, null, 'question'],
    //     [QuestionType::OPEN, ['kaixo'], 'options'],
    //     [QuestionType::OPEN, Str::rand(256), 'options'],
    //     [null, 'froga, 'type'],
    //     ['error', 'froga, 'type'],
    // ]