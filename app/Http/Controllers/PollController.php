<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        return view('polls.index', [
            'polls' => Poll::get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('polls.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'date|date_format:Y-m-d',
        ]);
        Poll::create($validated);
        return redirect(route('polls.index'));
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
    public function edit(Poll $poll): View
    {
        return view('polls.edit', [
            'poll' => $poll,
        ]);
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
    public function destroy(Poll $poll):RedirectResponse
    {
        $poll->delete();
        return redirect(route('polls.index'));
    }
    
    public function restore($poll):RedirectResponse
    {
        $pol = Poll::withTrashed()->findOrFail($poll);
        $pol->restore();
        return redirect(route('polls.index'));
    }

    public function trash(): View{
        $polls = Poll::onlyTrashed()->get();
        return view('polls.trash',[
            'polls' => $polls,
        ]);
    }
}
