<?php

namespace App\Policies;

use App\User;
use App\AnswerComment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerCommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any answer comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the answer comment.
     *
     * @param  \App\User  $user
     * @param  \App\AnswerComment  $answerComment
     * @return mixed
     */
    public function view(User $user, AnswerComment $answerComment)
    {
        //
    }

    /**
     * Determine whether the user can create answer comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the answer comment.
     *
     * @param  \App\User  $user
     * @param  \App\AnswerComment  $answerComment
     * @return mixed
     */
    public function update(User $user, AnswerComment $answerComment)
    {
        return $user->id === $answerComment->user->id && !$answerComment->answer->thread->is_solved;
    }

    /**
     * Determine whether the user can delete the answer comment.
     *
     * @param  \App\User  $user
     * @param  \App\AnswerComment  $answerComment
     * @return mixed
     */
    public function delete(User $user, AnswerComment $answerComment)
    {
        return $user->id === $answerComment->user->id || $user->role === User::ROLE_ADMIN;
    }
}
