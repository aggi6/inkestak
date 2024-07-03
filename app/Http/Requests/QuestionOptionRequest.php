<?php

namespace App\Http\Requests;

use App\Http\Classes\QuestionType;
use Illuminate\Foundation\Http\FormRequest;
use Tests\Unit\Models\QuestionTest;

class QuestionOptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $questionType = $this->request->get('type');

        $rules = [
            'options' => 'nullable'
        ];

        if ($questionType == QuestionType::CLOSE) {
            $rules = [
                'options' => 'required|array',
                'options.*' => 'required|string|max:50',
            ];
        }
        
        return $rules;
    }
}
