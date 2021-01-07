<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadLike extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function thread()
    {
        return $this->belongsTo(\App\Thread::class);
    }
}
