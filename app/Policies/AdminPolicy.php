<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function onlyAdmin(User $user): bool
    {
        return $user->role === "admin";
    }
}
