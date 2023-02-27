<?php

namespace App\Services;

use App\Entities\User;

class UserService
{
    private const ADMIN_ROLE = 'admin';

    public function isAdmin(User $user): bool
    {
        return $user->getRole() === self::ADMIN_ROLE;
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