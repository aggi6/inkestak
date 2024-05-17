<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Polled extends Model
{
    use HasFactory;
    public function poll(){
        return $this->belongsTo(Poll::class);
    }
}
