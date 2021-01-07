<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerComment extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function answer()
    {
        return $this->belongsTo(\App\Answer::class);
    }
}
