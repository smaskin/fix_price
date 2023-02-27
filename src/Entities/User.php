<?php

namespace App\Entities;

class User
{
    private const ENABLED_STATUS = 'enabled';
    private const ROLES = ['admin', 'user'];
    private const PERMISSIONS = ['limited', 'unlimited'];


    public function __construct(private string $status, private string $role, private string $permission, private int $activity)
    {
    }

    public function isEnabledStatus(): string
    {
        return $this->status === self::ENABLED_STATUS;
    }

    public function getRole(): string|bool
    {
        return $this->role;
    }

    public function hasRole(): bool
    {
        return in_array($this->role, self::ROLES, true);
    }

    public function hasPermission(): bool
    {
        return in_array($this->permission, self::PERMISSIONS, true);
    }

    public function getPermission(): string
    {
        return $this->permission;
    }

    public function isAdmin(): bool
    {
        return $this->getRole() === 'admin';
    }

    public function isClient(): bool
    {
        return $this->role === 'user';
    }

    public function hasUnlimitedAccess(): bool
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