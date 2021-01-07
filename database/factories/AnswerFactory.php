<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use App\Thread;
use App\User;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'thread_id' => function () {
            return Thread::inRandomOrder()->first()->id;
        },
        'body' => $faker->paragraphs(5, true),
    ];
});
