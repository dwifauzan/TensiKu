<?php

namespace App\Policies;

use App\Models\Tip;
use App\Models\User;

class TipPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Tip $tip): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Tip $tip): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Tip $tip): bool
    {
        return $user->isAdmin();
    }
}