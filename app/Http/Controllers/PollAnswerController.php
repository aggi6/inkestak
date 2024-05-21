<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\View\View;
use App\Models\PollAnswer;
use Illuminate\Http\Request;

class PollAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $answers = PollAnswer::get();
        return view('answers.index', [
            'answers' => $answers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $polls = Poll::with('question')->get();
        return view('answers.create', [
            'polls' => $polls,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'poll_id' => 'required|exists:polls,id',
            'question_id' => 'required|exists:questions,id',
            'polled_id' => 'required|exists:polleds,id',
            'answer' => 'required|string',
        ]);
        PollAnswer::create($validatedData);
        return redirect(route('answers.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PollAnswer $pollAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PollAnswer $pollAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PollAnswer $pollAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PollAnswer $pollAnswer)
    {
        //
    }
}
