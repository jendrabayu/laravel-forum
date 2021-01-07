<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JustBetter\PaginationWithHavings\PaginationWithHavings;

class Thread extends Model
{

    use PaginationWithHavings;

    protected $guarded = [];

    protected $casts = [
        'is_solved' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Category::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function threadLikes()
    {
        return $this->hasMany(\App\ThreadLike::class);
    }

    public function answers()
    {
        return $this->hasMany(\App\Answer::class);
    }
}
