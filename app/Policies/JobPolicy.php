<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Job $job)
    {
        if ($user->company_id === $job->company_id)
            return true;

        return false;
    }

    public function updateAvailability(User $user, Job $job)
    {
        if (in_array($user->role, ['Admin', 'Manager']) and $user->company_id === $job->company_id and !in_array($job->status, ['PENDING', 'RESTRICTED']))
            return true;

        return false;
    }

    public function viewApplications(User $user, Job $job)
    {
        if ($user->company_id === $job->company_id)
            return true;

        return false;
    }
}
