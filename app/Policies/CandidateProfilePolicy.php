<?php

namespace App\Policies;

use App\Models\CandidateProfile;
use App\Models\User;

class CandidateProfilePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function showQualifications(User $user, CandidateProfile $profile)
    {
        if ($user->role !== 'Candidate' or $user->candidateProfile()->pluck('id')->first() === $profile->id)
            return true;

        return false;
    }
}
