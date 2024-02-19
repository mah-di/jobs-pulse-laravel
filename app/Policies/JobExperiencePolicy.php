<?php

namespace App\Policies;

use App\Models\JobExperience;
use App\Models\User;

class JobExperiencePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, JobExperience $experience)
    {
        if ($user->role !== 'Candidate' or $user->candidateProfile()->pluck('id')->first() === $experience->candidate_profile_id)
            return true;

        return false;
    }

    public function updateOrDelete(User $user, JobExperience $experience)
    {
        if ($user->candidateProfile()->pluck('id')->first() === $experience->candidate_profile_id)
            return true;

        return false;
    }
}
