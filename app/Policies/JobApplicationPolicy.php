<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\User;

class JobApplicationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, JobApplication $application)
    {
        if (in_array($user->role, ['Admin', 'Manager']) and $user->company_id === $application->job()->pluck('company_id')->first())
            return true;

        return false;
    }

    public function delete(User $user, JobApplication $application)
    {
        if ($application->status !== 'ACCEPTED' and $user->candidateProfile()->pluck('id')->first() === $application->candidate_profile_id)
            return true;

        return false;
    }
}
