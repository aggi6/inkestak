<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\belongsTo;


class PollAnswer extends Model
{
    use HasFactory;
    protected $table = 'pollAnswers';
    protected $fillable = [
        'poll_id',
        'polled_id',
        'question_id',
        'answer'
    ];
    public function question(){
        return $this->belongsTo(Question::class, 'question_id');
    }
    public function poll(){
        return $this->belongsTo(Poll::class, 'poll_id');
    }
    public function polled(){
        return $this->belongsTo(Polled::Class, 'polled_id');
    }
}
