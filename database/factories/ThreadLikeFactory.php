<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thread;
use App\ThreadLike;
use App\User;
use Faker\Generator as Faker;

$factory->define(ThreadLike::class, function (Faker $faker) {

    return [
        'user_id' => function () {
            
        },
        'thread_id' => function () {

        }
    ];
});
