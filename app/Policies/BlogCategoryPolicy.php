<?php

namespace App\Policies;

use App\Models\BlogCategory;
use App\Models\User;

class BlogCategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, BlogCategory $category)
    {
        if (in_array($user->role, ['Site Admin', 'Site Manager', 'Admin', 'Manager']) and $user->company_id === $category->company_id)
            return true;

        return false;
    }
}
