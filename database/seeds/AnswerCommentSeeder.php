<?php

use App\AnswerComment;
use Illuminate\Database\Seeder;

class AnswerCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AnswerComment::class, 250)->create();
    }
}
