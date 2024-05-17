<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Poll extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date',
    ];
    public function question(){
        return $this->hasMany(Question::class, 'poll_id');
    }
    public function pollAnswer(){
        return $this->belongsToMany(SAnswer::class, 'poll_id');
    }  
}
