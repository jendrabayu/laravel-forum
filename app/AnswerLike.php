<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerLike extends Model
{
    protected $guarded = [];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function answer()
    {
        return $this->belongsTo(\App\Answer::class);
    }

}
