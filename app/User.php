<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name'];

    public function threads()
    {
        return $this->hasMany(\App\Thread::class);
    }

    public function threadLikes()
    {
        return $this->hasMany(\App\ThreadLike::class);
    }

    public function answers()
    {
        return $this->hasMany(\App\Answer::class);
    }

    public function answerLikes()
    {
        return $this->hasMany(\App\AnswerLike::class);
    }

    public function answerComments()
    {
        return $this->hasMany(\App\AnswerComment::class);
    }

    public function getFullNameAttribute()
    {
        if (!$this->attributes['last_name']) {
            return $this->attributes['first_name'];
        }
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }
}
