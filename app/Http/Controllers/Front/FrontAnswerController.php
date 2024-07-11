<?php

namespace App\Http\Controllers\Front;

use App\Models\Poll;
use App\Models\Polled;
use App\Models\Question;
use Illuminate\View\View;
use App\Models\PollAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FrontAnswerController extends Controller
{
    public function polled():View{
        return view('front.polled');
    }
    public function polledCreate(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'email|nullable',
            'jaiotzeData' => 'date_format:Y-m-d|nullable',
            'postalCode' => 'string|max:5|nullable',
            'genre' => 'string|max:20|nullable',
        ]);
        $polled = Polled::create($validated);
        return redirect(route('front.polls', $polled));
    }
    public function polls(Polled $polled):View{
        return view('front.polls',[
            'polls' => Poll::with('question')->get(),
            'polled' => $polled,  
        ]);
    }
    public function create(Polled $polled, Poll $poll):View{
        return view('front.create', [
            'poll'=>$poll,
            'polled' =>$polled,
        ]);
    }
    public function store(Request $request, $polled, $poll):redirectResponse{
        $validated = $request->validate([
            'answer' => 'required|array',
            'answer.*' => 'required|string',
        ]);
        foreach ($validated['answer'] as $questionId => $answer){
            $validated['poll_id'] = $poll;
            $validated['polled_id'] = $polled;
            $validated['question_id'] = $questionId;
            $validated['answer'] = $answer;
            PollAnswer::create($validated);            
        }
        return redirect(route('answers.index'));
    }
}
