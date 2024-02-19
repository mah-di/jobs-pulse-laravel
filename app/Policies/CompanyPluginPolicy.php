<?php

namespace App\Policies;

use App\Models\CompanyPlugin;
use App\Models\User;

class CompanyPluginPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function updateStatus(User $user, CompanyPlugin $plugin)
    {
        if ($user->company_id === $plugin->company_id and !in_array($plugin->status, ['PENDING', 'REJECTED']))
            return true;

        return false;
    }
}
