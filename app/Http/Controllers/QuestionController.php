<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Question;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;

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
    public function create(Poll $poll):View
    {
        return view('questions.create', [
            'poll' => $poll,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Poll $poll): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
        ]);
        $validated['poll_id'] = $poll->id;
        Question::create($validated);
        return redirect(route('polls.index'));
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
    public function edit(Question $question):View
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
