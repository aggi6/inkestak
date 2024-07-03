<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'poll_id',
        'type',
    ];
    public function poll(){
        return $this->belongsTo(Poll::class);
    }
    public function pollAnswer(){
        return $this->belongsTo(PollAnswer::class);
    }
    public function options(){
        return $this->hasMany(QuestionOption::class);

    }
}
