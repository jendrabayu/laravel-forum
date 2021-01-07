<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Thread;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    $title = $faker->text;
    return [
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'category_id' => function () {
            return Category::inRandomOrder()->first()->id;
        },
        'title' => $title,
        'slug' => Str::slug($title),
        'body' => $faker->paragraphs(10, true),
        'is_solved' => $faker->boolean(25)
    ];
});
