<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use App\AnswerComment;
use App\User;
use Faker\Generator as Faker;

$factory->define(AnswerComment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'answer_id' => function () {
            return Answer::inRandomOrder()->first()->id;
        },
        'body' => $faker->paragraphs(2, true),
    ];
});
