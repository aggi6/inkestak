<?php

namespace App\Http\Requests;

use App\Http\Classes\QuestionType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'question' => 'required|string|max:255',
            'type' => 'required|in:' . QuestionType::OPEN . ',' . QuestionType::CLOSE,
        ];
    }
}
