<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class pollAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'poll_id',
        'polled_id',
        'question_id',
    ];
    public function question(){
        return $this->hasMany(Question::class);
    }
    public function poll(){
        return $this->hasMany(Poll::class);
    }
    public function polled(){
        return $this->hasMany(Polled::Class);
    }
}
