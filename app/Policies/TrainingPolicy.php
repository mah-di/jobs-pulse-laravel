<?php

namespace App\Policies;

use App\Models\Training;
use App\Models\User;

class TrainingPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Training $training)
    {
        if ($user->role !== 'Candidate' or $user->candidateProfile()->pluck('id')->first() === $training->candidate_profile_id)
            return true;

        return false;
    }

    public function updateOrDelete(User $user, Training $training)
    {
        if ($user->candidateProfile()->pluck('id')->first() === $training->candidate_profile_id)
            return true;

        return false;
    }
}
