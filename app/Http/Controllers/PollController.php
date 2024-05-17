<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        return view('polls.index', [
            'polls' => Poll::with('question')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Poll $poll)
    {
        Gate::authorize('create', $poll);
        return view('polls.create', [
            'poll' => $poll,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Poll $poll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poll $poll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poll $poll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poll $poll)
    {
        //
    }
}
