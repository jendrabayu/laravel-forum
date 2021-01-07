<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_best_answer' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function thread()
    {
        return $this->belongsTo(\App\Thread::class);
    }

    public function answerComments()
    {
        return $this->hasMany(\App\AnswerComment::class);
    }

    public function answerLikes()
    {
        return $this->hasMany(\App\AnswerLike::class);
    }
}
