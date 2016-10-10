<?php

namespace Pi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Pi\Auth\User;
use Pi\Clients\Courses\Quizzes\Quiz;

class QuizPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manage(User $user, Quiz $quiz)
    {
        return true;
    }
}
