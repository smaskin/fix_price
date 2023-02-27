<?php

namespace App\Services;

use App\Entities\User;

class UserService
{
    public function isAdmin(User $user): bool
    {
        return $user->getRole() === 'admin';
    }

    public function inLimitedRange(User $user, int $limit): bool
    {
        return $user->hasLimitedAccess() && $user->getActivity() < $limit;
    }

    public function inPremiumRange(User $user, int $limit): bool
    {
        return $user->hasPremiumAccess() && $user->getActivity() < $limit;
    }
}