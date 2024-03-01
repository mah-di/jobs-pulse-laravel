<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function takeVeryImportantDecision(User $user)
    {
        if ($user->role === 'Site Admin')
            return true;

        return false;
    }

    public function takeImportantDecision(User $user)
    {
        if (in_array($user->role, ['Site Admin', 'Site Manager']))
            return true;

        return false;
    }

    public function takeAdminDecision(User $user)
    {
        if ($user->role === 'Admin')
            return true;

        return false;
    }

    public function takeManagerialDecision(User $user)
    {
        if (in_array($user->role, ['Admin', 'Manager']))
            return true;

        return false;
    }

    public function updateActivity(User $user, Company $company)
    {
        if ($user->role === 'Admin' and $user->company_id === $company->id and !in_array($company->status, ['PENDING', 'RESTRICTED']))
            return true;

        return false;
    }

    public function createEmployees(User $user)
    {
        if (in_array($user->role,  ['Site Admin', 'Admin']))
            return true;

        return false;
    }

    public function updateOrDeleteEmployees(User $admin, User $user)
    {
        if (in_array($admin->role,  ['Site Admin', 'Admin']) and !in_array($user->role, ['Site Admin', 'Admin']) and $admin->company_id === $user->company_id)
            return true;

        return false;
    }
}
