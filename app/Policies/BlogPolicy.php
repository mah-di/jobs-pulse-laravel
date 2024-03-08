<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;

class BlogPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Blog $blog)
    {
        if ($user->profile()->pluck('id')->first() === $blog->profile_id)
            return true;

        return false;
    }

    public function delete(User $user, Blog $blog)
    {
        if ($user->profile()->pluck('id')->first() === $blog->profile_id or $user->role === 'Site Admin' or ($user->role === 'Admin' and $user->company_id === $blog->company_id))
            return true;

        return false;
    }
}
