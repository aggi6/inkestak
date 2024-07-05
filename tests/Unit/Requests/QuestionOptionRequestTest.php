<?php

namespace Tests\Unit\Requests;

use App\Http\Classes\QuestionType;
use Tests\TestCase;
use App\Http\Requests\QuestionOptionRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;

class QuestionOptionRequestTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function test_validation_rules($value, $type, $expectedResult): void
    {
        $request = new QuestionOptionRequest();
        $request->merge(['type' => $type] + $value);
        $rules = $request->rules();
        
        $validator = Validator::make(
            $request->all(),
            $rules
        );

        $result = $validator->passes();
        $this->assertEquals($expectedResult, $result);
    }

    public static function dataProvider(): array
    {
        return [
            
            [['options' =>['asd', 'asda']], QuestionType::CLOSE, true], 
            [['options' => ['asd']], QuestionType::CLOSE, true],            
            [['options' => []], QuestionType::CLOSE, false],                 
            [[], QuestionType::CLOSE, false],                     
            [['options' => [null]], QuestionType::CLOSE, false],                     
            [['options' => ['asd']], QuestionType::OPEN, false],            
            [['options' => []], QuestionType::OPEN, false],                      
            [[], QuestionType::OPEN, true],                      
        ];
    }
}

