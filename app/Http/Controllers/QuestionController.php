<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Question;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\QuestionOption;
use App\Http\Classes\QuestionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\QuestionOptionRequest;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**public function index():View
    {
        //
    }*/

    /**
     * Show the form for creating a new resource.
     */
    public function create(Poll $poll): View
    {
        return view('questions.create', [
            'poll' => $poll,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request, QuestionOptionRequest $optionRequest, Poll $poll): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $validatedQuestion = $request->validated();

            $validatedQuestion['poll_id'] = $poll->id;

            $question = Question::create($validatedQuestion);

            if ($question->type == QuestionType::CLOSE) {
                $validatedOptionQuestion = $optionRequest->validated();
    
                foreach ($validatedOptionQuestion['options'] as $option) {
                    QuestionOption::create([
                        'option' => $option,
                        'question_id' => $question->id
                    ]);
                }
            }

            DB::commit();

            return redirect(route('polls.index'));
        } catch (\Throwable $th) {
            DB::rollback();

            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question): View
    {
        return view('questions.edit', [
            'question' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $question->update($validated);
        return redirect(route('polls.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect(route('polls.index'));
    }
}
