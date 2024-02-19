<?php

namespace App\Policies;

use App\Models\EducationalDetail;
use App\Models\User;

class EducationalDetailPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, EducationalDetail $education)
    {
        if ($user->role !== 'Candidate' or $user->candidateProfile()->pluck('id')->first() === $education->candidate_profile_id)
            return true;

        return false;
    }
}
