<?php

namespace App\Entities;

class User
{
    private const ENABLED_STATUS = 'enabled';
    private const ROLES = ['admin', 'user'];
    private const PERMISSIONS = ['limited', 'unlimited'];


    public function __construct(
        private string $status,
        private string $role,
        private string $permission,
        private int    $activity)
    {
    }

    public function isEnabledStatus(): bool
    {
        return $this->status === self::ENABLED_STATUS;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function hasRole(): bool
    {
        return in_array($this->role, self::ROLES, true);
    }

    public function checkPermission(): bool
    {
        return in_array($this->permission, self::PERMISSIONS, true);
    }

    public function getPermission(): string
    {
        return $this->permission;
    }

    public function hasPremiumAccess(): bool
    {
        return $this->permission === 'unlimited';
    }

    public function hasLimitedAccess(): bool
    {
        return $this->permission === 'limited';
    }

    public function getActivity(): int
    {
        return $this->activity;
    }
}